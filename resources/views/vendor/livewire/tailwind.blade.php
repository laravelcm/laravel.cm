@php
    if (! isset($scrollTo)) {
        $scrollTo = 'body';
    }

    $scrollIntoViewJsSnippet =
        $scrollTo !== false
            ? <<<JS
               (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
            JS
            : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex flex-1 justify-between sm:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex cursor-default items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                        >
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button
                            type="button"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-none active:bg-skin-footer"
                        >
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button
                            type="button"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before"
                            class="focus:shadow-outline-green relative ml-3 inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-none active:bg-skin-footer"
                        >
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span
                            class="relative ml-3 inline-flex cursor-default items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                        >
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p class="font-sans text-sm leading-5 text-gray-500 dark:text-gray-400">
                        <span>{!! __('pagination.showing') !!}</span>
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        <span>{!! __('pagination.to') !!}</span>
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                        <span>{!! __('pagination.of') !!}</span>
                        <span class="font-medium">{{ $paginator->total() }}</span>
                        <span>{!! __('pagination.results') !!}</span>
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex rounded-lg shadow-sm">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                    <span
                                        class="relative inline-flex cursor-default items-center rounded-l-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
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
                                <button
                                    type="button"
                                    wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="prev"
                                    class="focus:shadow-outline-green relative inline-flex items-center rounded-l-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:text-gray-400 dark:text-gray-500 focus:z-10 focus:border-green-300 focus:outline-none active:bg-skin-footer active:text-gray-500 dark:text-gray-400"
                                    aria-label="{{ __('pagination.previous') }}"
                                >
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span
                                        class="relative -ml-px inline-flex cursor-default items-center border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-700"
                                    >
                                        {{ $element }}
                                    </span>
                                </span>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                                        @if ($page == $paginator->currentPage())
                                            <span aria-current="page">
                                                <span
                                                    class="relative -ml-px inline-flex cursor-default items-center border border-gray-200 dark:border-white/10 bg-gray-100/40 dark:bg-gray-700 px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                                                >
                                                    {{ $page }}
                                                </span>
                                            </span>
                                        @else
                                            <button
                                                type="button"
                                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                                class="focus:shadow-outline-green relative -ml-px inline-flex items-center border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:z-10 focus:border-green-300 focus:outline-none active:bg-skin-footer"
                                                aria-label="{{ __('pagination.go_to_page', ['page' => $page]) }}"
                                            >
                                                {{ $page }}
                                            </button>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button
                                    type="button"
                                    wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                    x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after"
                                    rel="next"
                                    class="focus:shadow-outline-green relative -ml-px inline-flex items-center rounded-r-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out hover:text-gray-400 dark:text-gray-500 focus:z-10 focus:border-green-300 focus:outline-none active:bg-skin-footer active:text-gray-500 dark:text-gray-400"
                                    aria-label="{{ __('pagination.next') }}"
                                >
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span
                                        class="relative -ml-px inline-flex cursor-default items-center rounded-r-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-2 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
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
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
