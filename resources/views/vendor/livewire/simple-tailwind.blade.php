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
                        class="relative inline-flex cursor-default items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-base"
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
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-inverted transition duration-150 ease-in-out hover:text-skin-base focus:border-green-300 focus:outline-none active:bg-skin-footer"
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
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-inverted transition duration-150 ease-in-out hover:text-skin-base focus:border-green-300 focus:outline-none active:bg-skin-footer"
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
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-inverted transition duration-150 ease-in-out hover:text-skin-base focus:border-green-300 focus:outline-none active:bg-skin-footer"
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
                            class="focus:shadow-outline-green relative inline-flex items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-inverted transition duration-150 ease-in-out hover:text-skin-base focus:border-green-300 focus:outline-none active:bg-skin-footer"
                        >
                            {!! __('pagination.next') !!}
                        </button>
                    @endif
                @else
                    <span
                        class="relative inline-flex cursor-default items-center rounded-md border border-skin-input bg-skin-card px-4 py-2 text-sm font-medium leading-5 text-skin-base"
                    >
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
