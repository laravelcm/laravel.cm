@props(['title', 'content'])

<div>
    <h3 class="text-skin-inverted text-2xl sm:text-3xl leading-7 font-sans font-semibold">{{ $title }}</h3>
    <p class="mt-3 text-lg sm:text-xl leading-6 font-normal text-skin-base sm:max-w-3xl">{{ $content }}</p>
</div>
