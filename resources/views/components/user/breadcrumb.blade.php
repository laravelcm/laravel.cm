@props(['section'])

<nav class="flex mb-3" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="{{ route('dashboard') }}" class="text-skin-muted hover:text-skin-base">
                    <x-heroicon-s-home class="shrink-0 h-5 w-5" />
                    <span class="sr-only">Accueil</span>
                </a>
            </div>
        </li>

        <li>
            <div class="flex items-center">
                <svg class="shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                </svg>
                <span href="#" class="ml-4 text-sm font-medium text-skin-base" aria-current="page">{{ $section }}</span>
            </div>
        </li>
    </ol>
</nav>
