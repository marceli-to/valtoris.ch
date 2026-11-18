# valtoris.ch

Website of valtoris gmbh (HR · IT · Consulting). Read `README.md` for the layout of the project and `docs/progress.md` for what's done and what's open; update the latter at the end of a session.

Design source: Figma `V05_Valtoris_website` (file key `6VX6TwVmIcKqn7WJ6cUCYC`): pages «Current Version Desktop» (`32:198`), «Current Version Mobile» (`359:36`), «Assets (Export)» (`383:139`), «Style» (`269:2`).

## Conventions

- Tabs for indentation everywhere (PHP, Blade, JS, CSS). Don't run Pint; it converts to spaces.
- Slim controllers. Business logic in `app/Actions/*` (`execute()`), validation in `app/Http/Requests`, JSON via `app/Http/Resources`.
- Tailwind 4 only. Spacing unit is 1px (`--spacing: 0.0625rem`), so `px-12` = 12px. Type scale `text-xs` (14) … `text-11xl` (100), no `text-base`; `text-md` is 16px. Reused UI (buttons, arrow links, eyebrows, form fields) are Blade components in `resources/views/components` with the utilities inside; no generic `btn`-style classes. `@utility` + `@apply` in `app.css` only for layout, headings and gradient backgrounds; avoid plain CSS.
- Alpine.js for the mobile menu and the contact form; nothing else needs JavaScript.
- Content lives in `config/valtoris.php`, German (Swiss spelling: «ss», no «ß»).
- Images: sources in `resources/images`, listed in `images.json`, rendered by `npm run images`; use `<x-picture>`.
- `npm run build` and commit `public/build` (the server has no Node). Run `php artisan test` before committing.
