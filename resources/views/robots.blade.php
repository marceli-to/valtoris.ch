User-agent: *
@if ($indexable)
Disallow:

Sitemap: {{ rtrim(config('app.url'), '/') }}/sitemap.xml
@else
Disallow: /
@endif
