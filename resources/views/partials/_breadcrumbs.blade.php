@unless ($breadcrumbs->isEmpty())
    <ol class="py-2 flex items-center text-sm">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && ! $loop->last)
                <li>
                    <x-link :href="$breadcrumb->url" class="text-gray-700 hover:text-primary-600 hover:underline dark:text-gray-300 dark:hover:text-primary-500">
                        {{ $breadcrumb->title }}
                    </x-link>
                </li>
            @else
                <li class="truncate text-gray-500 dark:text-gray-400">
                    {{ $breadcrumb->title }}
                </li>
            @endif

            @unless ($loop->last)
                <li class="inline-flex items-center px-2.5">
                    <x-phosphor-caret-right-duotone class="size-4 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                </li>
            @endif
        @endforeach
    </ol>
@endunless
