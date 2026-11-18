# Progress

What has been done, newest first. What's still open is in `docs/missing.md`.

## 2026-11-18

### Polish

- Burger and close button flush with the content edge (removed the `-mr-12` nudge).
- Buttons a fixed 48px tall (`h-48`); desktop Kontakt button 100×48.
- Impressum and Datenschutz back to the design: empty first column, text from the second.
- Team photos: the quote overlay is 85% opaque, so the portrait shows through; name and role fade out while the quote shows.

### 4px rhythm

- Rounded every padding, margin, gap and scroll offset to a multiple of 4 (box bottoms `pb-140`/`pb-148`, anchors `scroll-mt-88`/`scroll-mt-128`, …). Element sizes (logo, burger bars, 99px pattern band) and line-heights stay as in the design.
- `SpacingRhythmTest` fails as soon as an off-grid spacing utility appears in a view or `app.css`.
- Split the notes: `docs/progress.md` (done) and `docs/missing.md` (open).

### CI fixes

- Pinned the Composer platform to PHP 8.3 (`config.platform.php`), as on the other sites. The lock had been resolved under PHP 8.4 and pulled in Symfony 8.1, which broke `composer install` on CI (PHP 8.3); it now uses Symfony 7.4.
- Removed the empty `Unit` suite from `phpunit.xml`. GitHub Actions is green since `9df22b3`.

### Feedback round

- Buttons, arrow links, eyebrows and contact fields are Blade components (`<x-button>`, `<x-link-arrow>`, `<x-eyebrow>`, `<x-contact-field>`) instead of generic `@utility` classes. `app.css` keeps `@utility` only for layout, headings and gradient backgrounds.
- The select chevron is bundled by Vite, so it also shows when `npm run dev` is running.
- Mobile menu: same header box as the page, so the logo no longer jumps when it opens; no scroll lock, so the scrollbar stays.
- Site registered in Herd with SSL: https://valtoris.ch.test.

### First build

- Laravel 13 + Tailwind 4 + Vite + Alpine. Repository: https://github.com/marceli-to/valtoris.ch.
- Home page from the Figma file, desktop and mobile: header with mobile menu, hero (video slot under the gradient layers), topic band (marquee), seven services + CTA tile, healthcare, team (quote on hover/tap), contact, footer. Impressum and Datenschutz.
- Contact form: `ContactRequest` + Cloudflare Turnstile → `SubmitContactMessage` stores in SQLite, then mails `VALTORIS_CONTACT_RECIPIENT` (reply-to the sender). Posts in the background with Alpine; works without JavaScript. Throttled to 5 a minute.
- Jost self-hosted (subset latin, weights 300–500). Photos as AVIF/WebP/JPEG; favicons, web manifest, OG image, sitemap, robots.txt, llms.txt, JSON-LD.
- Drafted Impressum and Datenschutzerklärung (Swiss DSG), to be checked by valtoris.
- `deploy.sh` written; host and path still to fill in.
- Tests: pages, SEO files, image variants, contact form (store, mail, validation, Turnstile, mail failure, no-JS, rate limit).
