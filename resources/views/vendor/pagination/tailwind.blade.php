@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex flex-1 justify-between sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex cursor-default items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                >
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="focus:shadow-outline-green relative inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                >
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="focus:shadow-outline-green relative ml-3 inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                >
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative ml-3 inline-flex cursor-default items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                >
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="font-sans text-sm leading-5 text-gray-500 dark:text-gray-400">
                    <span>{!! __('Affichage de') !!}</span>
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    <span>{!! __('à') !!}</span>
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    <span>{!! __('sur') !!}</span>
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    <span>{!! __('résultats') !!}</span>
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-xs">
                    {{-- Previous Page Link --}}

                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="relative inline-flex cursor-default items-center rounded-l-md border border-skin-input bg-skin-card px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                            >
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a
                            href="{{ $paginator->previousPageUrl() }}"
                            rel="prev"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-l-md border border-skin-input bg-skin-card px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:text-gray-400 dark:text-gray-500 focus:z-10 focus:border-green-300 focus:outline-hidden active:bg-skin-footer active:text-gray-500 dark:text-gray-400"
                            aria-label="{{ __('pagination.previous') }}"
                        >
                            <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative -ml-px inline-flex cursor-default items-center border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-700"
                                >
                                    {{ $element }}
                                </span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative -ml-px inline-flex cursor-default items-center border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                                        >
                                            {{ $page }}
                                        </span>
                                    </span>
                                @else
                                    <a
                                        href="{{ $url }}"
                                        class="focus:shadow-outline-green relative -ml-px inline-flex items-center border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:z-10 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                                        aria-label="{{ __('Aller à la page :page', ['page' => $page]) }}"
                                    >
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}

                    @if ($paginator->hasMorePages())
                        <a
                            href="{{ $paginator->nextPageUrl() }}"
                            rel="next"
                            class="focus:shadow-outline-green relative -ml-px inline-flex items-center rounded-r-md border border-skin-input bg-skin-card px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:text-gray-400 dark:text-gray-500 focus:z-10 focus:border-green-300 focus:outline-hidden active:bg-skin-footer active:text-gray-500 dark:text-gray-400"
                            aria-label="{{ __('pagination.next') }}"
                        >
                            <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="relative -ml-px inline-flex cursor-default items-center rounded-r-md border border-skin-input bg-skin-card px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                            >
                                <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
