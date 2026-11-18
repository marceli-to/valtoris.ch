{{-- Source for public/images/og.png (1200×630). Regenerate with scripts/og-image.sh. --}}
<!DOCTYPE html>
<html lang="de-CH">
<head>
	<meta charset="utf-8">
	@fonts
	@vite(['resources/css/app.css'])
</head>
<body class="m-0">
	<div class="flex h-630 w-1200 flex-col gap-32 bg-white p-48">
		<img src="{{ asset('images/logo-valtoris.svg') }}" alt="" class="h-auto w-240">
		<div class="box bg-hero flex flex-1 flex-col justify-end px-56 pb-132">
			<div class="absolute inset-0 -z-20">
				<div class="bg-hero absolute inset-0"></div>
				<x-picture name="hero-poster" loading="eager" class="absolute inset-0 mix-blend-hard-light" img-class="size-full object-cover" />
				<div class="bg-hero absolute inset-0 opacity-27 mix-blend-multiply"></div>
				<div class="bg-hero absolute inset-0 mix-blend-hard-light"></div>
			</div>
			<p class="text-10xl font-medium tracking-[-0.03em] text-white">
				Wo <span class="text-plum-tint">HR &amp; Technologie</span><br>zusammenkommen.
			</p>
			<div class="pattern-band"></div>
		</div>
	</div>
</body>
</html>
