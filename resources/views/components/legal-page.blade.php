{{-- The frame of Impressum and Datenschutz: title, a line, and the text in the second to fourth column, as in the design. --}}
@props(['eyebrow', 'title', 'description'])

<x-layouts.app :title="$title.' – valtoris'" :description="$description">
	<div class="container-site pt-24 pb-80 md:pt-64 md:pb-160">
		<div class="flex flex-col gap-20 md:gap-28">
			<x-eyebrow class="text-plum">{{ $eyebrow }}</x-eyebrow>
			<h1 class="heading-page">{{ $title }}</h1>
		</div>

		<div class="mt-40 border-t border-verdant-tint pt-28 md:mt-80 md:pt-40 lg:grid lg:grid-cols-[320px_1fr]">
			<div class="flex max-w-788 flex-col gap-40 md:gap-48 lg:col-start-2 lg:pl-28">
				{{ $slot }}
			</div>
		</div>
	</div>
</x-layouts.app>
