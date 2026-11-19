# Missing

What's still needed before go-live. Tick it off here and note it in `docs/progress.md` when done.

## Files

- [x] **Hero video** (2026-11-19): `public/videos/valtoris.webm` + `valtoris.mp4`.
- [ ] **Profile PDFs** for the «Beraterprofil» links: `public/downloads/beraterprofil-linda-schwerzmann.pdf`, `public/downloads/beraterprofil-stephan-hugi.pdf`. The links appear once the files are there.

## Content

- [ ] **UID number** for the Impressum: `config/valtoris.php` → `company.uid` (until then it shows `CHE-XXX.XXX.XXX`).
- [ ] **Review of the legal texts** by valtoris. Assumptions to confirm: both partners represent the company (Impressum), hosting at Hostpoint (`config/valtoris.php` → `hosting`, Datenschutz).

## Accessibility

- [ ] **Contrast in «Gesundheitswesen»** (for stoz): white text on the teal gradient is 3.0:1 in the middle and 2.1:1 at the light end (`#6ebfd2`); AA needs 4.5:1 for body text, 3:1 for headings. Options: darker gradient end (e.g. `#2a8499`) or dark text.
- [ ] **Team quotes for keyboard users**: they only show on hover or tap; screen readers read them, but sighted keyboard users don't see them. Fix: make the photo focusable and show the quote on focus.
- [ ] **Hero video** (once it's there): no way to pause it except reduced motion. Consider pausing on hover or a small pause button.

## Deployment

- [ ] **Staging (valtoris.stoz.ch)**: SMTP in the server `.env` (mails only go to `storage/logs/laravel.log` now); `valtoris.stoz.ch` in the Turnstile widget's hostnames; one test message through the form.

- [ ] **Server details** for `deploy.sh`: SSH host and path.
- [ ] **Server `.env`**: `APP_ENV=production` (staging: `APP_ENV=staging`, which keeps robots.txt closed and adds `noindex`), `APP_URL=https://valtoris.ch`, `APP_KEY`, SMTP (`MAIL_*`), `MAIL_FROM_ADDRESS`, `VALTORIS_CONTACT_RECIPIENT` if not info@valtoris.ch.
- [x] **Cloudflare Turnstile widget** created for valtoris.ch (2026-11-18); site and secret key checked against Cloudflare.
- [ ] **Turnstile keys on the server**: `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY` in the server's `.env`. Locally the real keys only work if `valtoris.ch.test` is added to the widget's hostnames (otherwise error 110200); leave them empty locally to use Cloudflare's test keys.
- [ ] **PHP version** on the server: 8.3 or newer (the Composer platform is pinned to 8.3).
- [ ] **Go-live check**: contact form sends and arrives, OG image and favicon show, sitemap and robots.txt point to https://valtoris.ch.
