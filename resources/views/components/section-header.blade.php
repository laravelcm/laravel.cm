@props([
    'title',
    'content',
])

<div>
    <h3 class="font-heading text-2xl leading-7 text-skin-inverted sm:text-3xl">{{ $title }}</h3>
    <p class="mt-3 text-lg leading-6 text-skin-base sm:max-w-3xl sm:text-xl">{{ $content }}</p>
</div>
