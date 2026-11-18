# Missing

What's still needed before go-live. Tick it off here and note it in `docs/progress.md` when done.

## Files

- [ ] **Hero video** `Valtoris_Video.mp4` (1920 × 1080, 5 MB, from stoz; Figma only says "wird separat mitgeliefert"). Goes to `public/videos/valtoris.mp4`; the hero picks it up by itself. To do with it: compress it, add a `public/videos/valtoris.webm`, and re-render `resources/images/hero-poster.png` from its first frame if the current still differs (`npm run images`).
- [ ] **Profile PDFs** for the «Beraterprofil» links: `public/downloads/beraterprofil-linda-schwerzmann.pdf`, `public/downloads/beraterprofil-stephan-hugi.pdf`. The links appear once the files are there.

## Content

- [ ] **UID number** for the Impressum: `config/valtoris.php` → `company.uid` (until then it shows `CHE-XXX.XXX.XXX`).
- [ ] **Review of the legal texts** by valtoris. Assumptions to confirm: both partners represent the company (Impressum), hosting at Hostpoint (`config/valtoris.php` → `hosting`, Datenschutz).

## Deployment

- [ ] **Server details** for `deploy.sh`: SSH host and path.
- [ ] **Server `.env`**: `APP_URL=https://valtoris.ch`, `APP_KEY`, SMTP (`MAIL_*`), `MAIL_FROM_ADDRESS`, `VALTORIS_CONTACT_RECIPIENT` if not info@valtoris.ch.
- [x] **Cloudflare Turnstile widget** created for valtoris.ch (2026-11-18); site and secret key checked against Cloudflare.
- [ ] **Turnstile keys on the server**: `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY` in the server's `.env`. Locally the real keys only work if `valtoris.ch.test` is added to the widget's hostnames (otherwise error 110200); leave them empty locally to use Cloudflare's test keys.
- [ ] **PHP version** on the server: 8.3 or newer (the Composer platform is pinned to 8.3).
- [ ] **Go-live check**: contact form sends and arrives, OG image and favicon show, sitemap and robots.txt point to https://valtoris.ch.
