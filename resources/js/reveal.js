/**
 * Elements with data-reveal come into place as they scroll into view: this marks them
 * data-revealed, and the reveal utilities in app.css animate the change. Elements that come
 * into view together follow one another a few milliseconds apart, in page order;
 * data-reveal-delay="200" adds to that.
 *
 * The hidden starting state only applies under html.motion, which the inline script in the
 * layout sets when motion is allowed. Without JavaScript, with reduced motion, or if this
 * file doesn't load in time, everything simply stays visible.
 */
const STEP = 90;
const MAX_STAGGER = 540;

export default function reveal() {
	const root = document.documentElement;

	if (! root.classList.contains('motion') || ! ('IntersectionObserver' in window)) {
		root.classList.remove('motion');

		return;
	}

	window.valtorisReveal = true;

	const show = (element, delay) => {
		if (delay > 0) {
			element.style.transitionDelay = `${delay}ms`;

			// The delay is only for coming in; hover transitions later shouldn't wait.
			const clear = (event) => {
				if (event.target === element) {
					element.style.transitionDelay = '';
					element.removeEventListener('transitionend', clear);
				}
			};
			element.addEventListener('transitionend', clear);
		}

		element.dataset.revealed = '';
	};

	const observer = new IntersectionObserver((entries) => {
		entries
			.filter((entry) => entry.isIntersecting)
			.map((entry) => entry.target)
			.sort((a, b) => (a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1))
			.forEach((element, index) => {
				observer.unobserve(element);
				show(element, Math.min(index * STEP, MAX_STAGGER) + Number(element.dataset.revealDelay ?? 0));
			});
	}, { rootMargin: '0px 0px -8% 0px' });

	document.querySelectorAll('[data-reveal]').forEach((element) => observer.observe(element));
}
