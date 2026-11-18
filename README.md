# valtoris.ch

The website of valtoris gmbh, HR · IT · Consulting, Maladers. One page (services, healthcare, team, contact form) plus Impressum and Datenschutz, built from the Figma file `V05_Valtoris_website` (design by stoz).

Laravel 13, Tailwind CSS 4, Vite, Alpine.js. SQLite only holds the contact form messages.

## Local development

The site runs in [Herd](https://herd.laravel.com) at `https://valtoris.ch.test`.

```sh
composer install
npm install
cp .env.example .env && php artisan key:generate
touch database/database.sqlite && php artisan migrate
npm run dev       # or: npm run build
php artisan test
```

Locally, mail goes to the log (`MAIL_MAILER=log`) and Turnstile uses Cloudflare's test keys, which always pass.

## Deploying

```sh
npm run build     # if you changed the design; commit public/build
./deploy.sh
```

`deploy.sh` runs the tests, exports the committed code, installs production dependencies, syncs it to the server over SSH and runs the migrations. The server's `.env`, `public/.htaccess`, `storage/` and `database/database.sqlite` are left alone. On the server, `.env` needs `APP_URL=https://valtoris.ch`, the SMTP settings (`MAIL_*`), `TURNSTILE_SITE_KEY` / `TURNSTILE_SECRET_KEY` and, if not info@valtoris.ch, `VALTORIS_CONTACT_RECIPIENT`.

## Where things are

| | |
|---|---|
| `config/valtoris.php` | The content: company details, topic band, the seven services, the team (phones, emails, quotes, profile PDFs) |
| `resources/views/pages/home.blade.php` | The home page; its sections are in `pages/home/` |
| `resources/views/pages/impressum.blade.php`, `datenschutz.blade.php` | Legal pages, framed by `components/legal-page` |
| `resources/views/components/` | Layout (head, meta, JSON-LD), header with the mobile menu, footer, `<x-picture>`, and the UI pieces `<x-button>`, `<x-link-arrow>`, `<x-eyebrow>`, `<x-contact-field>` |
| `resources/css/app.css` | Theme: 1px spacing unit (`px-12` = 12px), the type scale (`text-xs` … `text-11xl`, no `text-base`), colours; `@utility` classes only for layout, headings and the gradient backgrounds |
| `resources/js/contact-form.js` | Posts the contact form in the background; without JavaScript it posts normally |
| `app/Http/Controllers/ContactController.php` | → `ContactRequest` (validation + `Rules\Turnstile`) → `Actions\Contact\SubmitContactMessage` (stores, then mails) → `ContactMessageResource` |
| `resources/images/` | Photo sources and `images.json`; `npm run images` renders AVIF/WebP/JPEG per width to `public/images` |
| `artwork/signet.svg` | Source of the favicons; `npm run icons` renders them |
| `resources/views/og-image.blade.php` | Source of `public/images/og.png`; render with `scripts/og-image.sh` (needs Herd and Chrome) |
| `public/videos/valtoris.mp4` | The hero video (not delivered yet); until it exists, its first frame stands in |
| `public/downloads/` | The profile PDFs; the «Beraterprofil» link appears once the file is there |
| `public/robots.txt`, `sitemap.xml`, `llms.txt` | For search engines and LLMs; add new pages here |

## Code style

Tabs, not spaces (see `.editorconfig`). Slim controllers; logic in `app/Actions`, validation in form requests, JSON through resources. Styles go through Tailwind. Reused UI (buttons, links, form fields) is a Blade component with the utilities inside, not a CSS class. Pint isn't used because it always indents with spaces.
