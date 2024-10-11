@props(['activeLinks', 'title', 'href' => '#'])

<x-link
    :href="$href"
    class="{{ active(
        $activeLinks,
        'text-primary-600 hover:text-primary-500',
        'text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'
   ) }} inline-flex items-center px-1 text-sm font-medium"
>
    {{ $title }}
</x-link>
