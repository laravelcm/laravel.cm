<nav class="relative z-0 flex divide-x divide-skin-base rounded-lg shadow" aria-label="Tabs">
    <a
        href="{{ url(request()->url() . '?sortBy=recent') }}"
        aria-current="{{ $filter === 'recent' ? 'page' : 'false' }}"
        class="{{ $filter === 'recent' ? 'text-skin-inverted' : 'text-skin-base hover:text-skin-inverted' }} group relative w-full min-w-0 flex-1 overflow-hidden rounded-l-lg bg-skin-card p-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10 sm:px-6"
    >
        <span>{{ __('Récent') }}</span>
        <span
            aria-hidden="true"
            class="{{ $filter === 'recent' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
        ></span>
    </a>

    <a
        href="{{ url(request()->url() . '?sortBy=resolved') }}"
        aria-current="{{ $filter === 'resolved' ? 'page' : 'false' }}"
        class="{{ $filter === 'resolved' ? 'text-skin-inverted' : 'text-skin-base hover:text-skin-inverted' }} group relative w-full min-w-0 flex-1 overflow-hidden bg-skin-card p-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10 sm:px-6"
    >
        <span>{{ __('Résolu') }}</span>
        <span
            aria-hidden="true"
            class="{{ $filter === 'resolved' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
        ></span>
    </a>

    <a
        href="{{ url(request()->url() . '?sortBy=unresolved') }}"
        aria-current="{{ $filter === 'unresolved' ? 'page' : 'false' }}"
        class="{{ $filter === 'unresolved' ? 'text-skin-inverted' : 'text-skin-base hover:text-skin-inverted' }} group relative w-full min-w-0 flex-1 overflow-hidden rounded-r-lg bg-skin-card p-4 text-center text-sm font-medium hover:bg-skin-card-muted focus:z-10 sm:px-6"
    >
        <span>{{ __('Non résolu') }}</span>
        <span
            aria-hidden="true"
            class="{{ $filter === 'unresolved' ? 'bg-skin-primary' : 'bg-transparent' }} absolute inset-x-0 bottom-0 h-0.5"
        ></span>
    </a>
</nav>
