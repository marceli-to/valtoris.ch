@props(['title'])

<section class="flex flex-col gap-16">
	<h2 class="text-xl font-medium text-verdant">{{ $title }}</h2>
	<div class="text-body flex flex-col gap-16 [&_a]:underline [&_a]:hover:text-plum [&_ul]:list-disc [&_ul]:pl-20">
		{{ $slot }}
	</div>
</section>
