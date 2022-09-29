<nav class="relative z-0 rounded-lg shadow flex divide-x divide-skin-base" aria-label="Tabs">
    <a
        href="{{ url(request()->url() . '?sortBy=recent') }}"
        aria-current="{{ $filter === 'recent' ? 'page' : 'false' }}"
        class="w-full {{ $filter === 'recent' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-l-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
    >
        <span>{{ __('Récent') }}</span>
        <span aria-hidden="true" class="{{ $filter === 'recent' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
    </a>

    <a
        href="{{ url(request()->url() . '?sortBy=resolved') }}"
        aria-current="{{ $filter === 'resolved' ? 'page' : 'false' }}"
        class="w-full {{ $filter === 'resolved' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
    >
        <span>{{ __('Résolu') }}</span>
        <span aria-hidden="true" class="{{ $filter === 'resolved' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
    </a>

    <a
        href="{{ url(request()->url() . '?sortBy=unresolved') }}"
        aria-current="{{ $filter === 'unresolved' ? 'page' : 'false' }}"
        class="w-full {{ $filter === 'unresolved' ? 'text-skin-inverted': 'text-skin-base hover:text-skin-inverted' }} rounded-r-lg group relative min-w-0 flex-1 overflow-hidden bg-skin-card p-4 sm:px-6 text-sm font-medium text-center hover:bg-skin-card-muted focus:z-10"
    >
        <span>{{ __('Non résolu') }}</span>
        <span aria-hidden="true" class="{{ $filter === 'unresolved' ? 'bg-skin-primary': 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"></span>
    </a>
</nav>
