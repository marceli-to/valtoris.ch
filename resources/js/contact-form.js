/**
 * The contact form. Without JavaScript it posts normally and the page comes back with
 * the errors or the thank-you note; with it, it posts in the background and only swaps
 * the form for the note. Turnstile puts its token into the form as cf-turnstile-response.
 *
 * Turnstile weighs about 2 MB, so its script only loads once the form comes near the
 * viewport (or a field gets focus), not with the page.
 */
const TURNSTILE_URL = 'https://challenges.cloudflare.com/turnstile/v0/api.js';

function loadTurnstile() {
	if (document.querySelector(`script[src="${TURNSTILE_URL}"]`)) {
		return;
	}

	const script = document.createElement('script');
	script.src = TURNSTILE_URL;
	script.async = true;
	document.head.append(script);
}

export default () => ({
	sending: false,
	sent: false,
	firstName: '',
	errors: {},
	failed: false,

	init() {
		if (! this.$el.querySelector('.cf-turnstile')) {
			return;
		}

		const observer = new IntersectionObserver((entries) => {
			if (entries.some((entry) => entry.isIntersecting)) {
				observer.disconnect();
				loadTurnstile();
			}
		}, { rootMargin: '800px 0px' });

		observer.observe(this.$el);
		this.$el.addEventListener('focusin', loadTurnstile, { once: true });
	},

	async submit() {
		if (this.sending) {
			return;
		}

		this.sending = true;
		this.failed = false;
		this.errors = {};

		try {
			const response = await fetch(this.$el.action, {
				method: 'POST',
				headers: { Accept: 'application/json' },
				body: new FormData(this.$el),
			});

			if (response.status === 422) {
				this.errors = (await response.json()).errors ?? {};
				this.resetChallenge();
				this.$nextTick(() => this.$el.querySelector('[aria-invalid="true"]')?.focus());
				return;
			}

			if (! response.ok) {
				throw new Error(`HTTP ${response.status}`);
			}

			this.firstName = (await response.json()).data?.first_name ?? '';
			this.sent = true;
			this.$nextTick(() => this.$refs.thanks?.focus());
		} catch {
			this.failed = true;
			this.resetChallenge();
		} finally {
			this.sending = false;
		}
	},

	error(field) {
		return this.errors[field]?.[0] ?? '';
	},

	resetChallenge() {
		window.turnstile?.reset(this.$el.querySelector('.cf-turnstile'));
	},
});
