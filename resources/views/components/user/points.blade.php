@props(['author'])

<span class="mx-1.5 inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-skin-card-gray text-skin-inverted-muted">
    {{ $author->getPoints() }} XP
</span>
