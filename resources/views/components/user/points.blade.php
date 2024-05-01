@props([
    'author',
])

<span
    class="mx-1.5 inline-flex items-center rounded-md bg-skin-card-gray px-2.5 py-0.5 text-xs font-medium text-skin-inverted-muted"
>
    {{ $author->getPoints() }} XP
</span>
