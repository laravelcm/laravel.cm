@props([
    'section',
])

<nav class="mb-3 flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-2">
        <li>
            <div>
                <a href="{{ route('dashboard') }}" class="text-skin-muted hover:text-gray-500 dark:text-gray-400">
                    <x-untitledui-home class="size-5 shrink-0" />
                    <span class="sr-only">Accueil</span>
                </a>
            </div>
        </li>

        <li>
            <div class="flex items-center">
                <svg
                    class="size-5 shrink-0 text-skin-muted"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    aria-hidden="true"
                >
                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                </svg>
                <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400" aria-current="page">
                    {{ $section }}
                </span>
            </div>
        </li>
    </ol>
</nav>
