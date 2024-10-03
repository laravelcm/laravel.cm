@props([
    'title',
    'content',
])

<div>
    <h3 class="font-heading font-bold text-xl leading-7 text-skin-inverted sm:text-2xl">{{ $title }}</h3>
    <p class="mt-2 leading-6 text-skin-base sm:max-w-3xl sm:text-base">{{ $content }}</p>
</div>
