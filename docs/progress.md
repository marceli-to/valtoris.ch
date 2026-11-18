# Progress

## 2026-11-18: first build

Done:

- Laravel 13 + Tailwind 4 + Vite + Alpine, served by Herd at https://valtoris.ch.test.
- Home page from the Figma file, desktop and mobile: header with mobile menu, hero (video slot under the gradient layers), topic band (marquee), seven services + CTA tile, healthcare, team (quote on hover/tap), contact, footer. Impressum and Datenschutz.
- Contact form: `ContactRequest` + Cloudflare Turnstile → `SubmitContactMessage` stores in SQLite, then mails `VALTORIS_CONTACT_RECIPIENT` (reply-to the sender). Posts in the background with Alpine; works without JavaScript. Throttled to 5 a minute.
- Jost self-hosted (subset latin, weights 300–500). Photos as AVIF/WebP/JPEG; favicons, web manifest, OG image, sitemap, robots.txt, llms.txt, JSON-LD.
- Drafted Impressum and Datenschutzerklärung (Swiss DSG), to be checked by valtoris.
- Tests: pages, SEO files, image variants, contact form (store, mail, validation, Turnstile, mail failure, no-JS, rate limit).

Open:

- [ ] Hero video `Valtoris_Video.mp4` → `public/videos/valtoris.mp4` (ideally also a `valtoris.webm` and smaller than the 5 MB original). Then re-render `resources/images/hero-poster.png` from its first frame if it differs.
- [ ] Profile PDFs → `public/downloads/beraterprofil-linda-schwerzmann.pdf`, `beraterprofil-stephan-hugi.pdf`.
- [ ] Deployment details for `deploy.sh` (host, path); server `.env` (SMTP, Turnstile keys).
- [ ] Turnstile site in the Cloudflare dashboard for valtoris.ch → keys.
- [ ] UID number for the Impressum (`config/valtoris.php` → `company.uid`); confirm hosting provider in the Datenschutz (`hosting`).
- [ ] valtoris to review the legal texts.
