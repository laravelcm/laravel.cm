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
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span
                        class="relative inline-flex cursor-default items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                    >
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    @if (method_exists($paginator, 'getCursorName'))
                        <button
                            type="button"
                            dusk="previousPage"
                            wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->previousCursor()->encode() }}"
                            wire:click="setPage('{{ $paginator->previousCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                        >
                            {!! __('pagination.previous') !!}
                        </button>
                    @else
                        <button
                            type="button"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                        >
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    @if (method_exists($paginator, 'getCursorName'))
                        <button
                            type="button"
                            dusk="nextPage"
                            wire:key="cursor-{{ $paginator->getCursorName() }}-{{ $paginator->nextCursor()->encode() }}"
                            wire:click="setPage('{{ $paginator->nextCursor()->encode() }}','{{ $paginator->getCursorName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                        >
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <button
                            type="button"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out hover:text-gray-500 dark:text-gray-400 focus:border-green-300 focus:outline-hidden active:bg-skin-footer"
                        >
                            {!! __('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span
                        class="relative inline-flex cursor-default items-center rounded-lg border border-gray-200 dark:border-white/10 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"
                    >
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
