# Progress

What has been done, newest first. What's still open is in `docs/missing.md`.

## 2026-11-23

### Elements pull up from below (client's wish: «heranziehen»)

- `resources/js/reveal.js` (IntersectionObserver) marks `[data-reveal]` elements `data-revealed` as they scroll into view; the `reveal` utility in `app.css` moves them up 24px and fades them in (800 ms, `ease-reveal`). Elements arriving together follow each other 90 ms apart in page order; `data-reveal-delay` adds to it. Used on the hero text, topic band, section headings and texts, the contents of the service cells (not the cells: the grid's line colour would show through while they fade), team cards and the contact column.
- The hidden starting state only applies under `html.motion`, set by an inline script in the layout head when reduced motion is off; if `reveal.js` hasn't run after 3 s the class is dropped and everything shows. Without JavaScript nothing is hidden; print shows everything.
- A first round also had the boxes opening up, hero lines rising from a mask, the video zooming, the pattern bands drawing in and the portraits zooming on hover. The client asked for something calmer, so only the pull-up stayed.
- Committed and pushed (`bf1f5a5`), not yet on staging: the deploy from Claude's shell was refused (`Permission denied (publickey)`), the SSH key is only available in your own terminal. Deploy from there.

## 2026-11-19

### Team photos in full resolution

- `resources/images/team-linda.jpg` and `team-stephan.jpg` replaced with the 2000px originals (were the 503px Figma exports). Rendered at 400, 800 and 1200px for retina screens; the 503px variants are gone.

### Contact email in valtoris style

- Mail theme `resources/views/vendor/mail/html/themes/valtoris.css` (set in `config/mail.php` → `markdown.theme`) with its own frame (`html/header`, `html/message`, `text/message`): PNG logo at the top of the card (`public/images/logo-mail.png`, rendered by `npm run icons`; email apps don't show SVG), an intro line («Über das Kontaktformular … ist eine neue Anfrage eingegangen»), details as a table, the message plain below the details, German footer with the company line.
- Details and message are HTML, not Markdown: what the sender types shows as typed (escaped), line breaks are kept. Separate plain-text version `mail/contact-message-text`. `ContactMailTest` covers both.

### Staging on valtoris.stoz.ch

- Deployed to `stozch@stoz.ch:/home/stozch/www/valtoris.ch` (Hostpoint): `DEPLOY_HOST=stozch@stoz.ch DEPLOY_PATH=/home/stozch/www/valtoris.ch ./deploy.sh`. Server `.env` with `APP_ENV=staging` (robots.txt closed, `noindex`), own `APP_KEY`, Turnstile keys, `MAIL_MAILER=log` until there's SMTP.
- `public/.htaccess` optimised: HTTPS redirect, no dotfiles, MIME types (AVIF, WebP, WebM, woff2, webmanifest), gzip, `/build` cached a year (`immutable`), images, videos and icons a week, security headers (nosniff, Referrer-Policy, X-Frame-Options, Permissions-Policy).
- Hostpoint selects PHP with `Use php-fpm latest` above `#@__HCP_END__@#` in `.htaccess`; `deploy.sh` reads those lines before the upload and puts them back after it.

### Hero video

- stoz's `valtoris_video_header.mp4` (1920 × 1080, 10 s, 4.8 MB) compressed with ffmpeg, without audio: `public/videos/valtoris.webm` (VP9, CRF 36, 0.6 MB) and `public/videos/valtoris.mp4` (H.264, CRF 26, faststart, 1.6 MB). Browsers take the WebM first. The existing poster already matches the first frame.

## 2026-11-18

### Accessibility check

- axe-core (WCAG 2.2 AA) on all pages, desktop and mobile, menu open and form with errors: no violations of our own (only Herd's local dev badge).
- Eyebrow square centred on the capitals: it hangs on the text baseline (raised 0.9px) instead of being flex-centred next to the label, so square and letters round to the same screen pixels wherever the eyebrow lands (checked at 1× and 2×, desktop and mobile).
- Links: underline at 50% of the link colour and 4px below the text (Chrome draws no underline under 1px, so this is how it gets finer); arrow links underline only the label, not the arrow. Footer «Design by stoz» and Impressum «Gestaltung: stoz» link to https://stoz.ch.
- The topic band pauses while the pointer is over it (`hover:[animation-play-state:paused]`); it already stopped for reduced motion.

### robots.txt per environment

- `/robots.txt` comes from `RobotsController`: open with the sitemap on production only, `Disallow: /` on local and staging. Non-production pages also carry `<meta name="robots" content="noindex, nofollow">`. The static `public/robots.txt` is gone.

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
