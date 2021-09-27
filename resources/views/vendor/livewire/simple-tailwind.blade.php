<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-skin-base bg-skin-card border border-skin-input cursor-default leading-5 rounded-md">
                        {!! __('pagination.previous') !!}
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-skin-inverted bg-skin-card border border-skin-input leading-5 rounded-md hover:text-skin-base focus:outline-none focus:shadow-outline-green focus:border-green-300 active:bg-skin-footer transition ease-in-out duration-150">
                        {!! __('pagination.previous') !!}
                    </button>
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-skin-inverted bg-skin-card border border-skin-input leading-5 rounded-md hover:text-skin-base focus:outline-none focus:shadow-outline-green focus:border-green-300 active:bg-skin-footer transition ease-in-out duration-150">
                        {!! __('pagination.next') !!}
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-skin-base bg-skin-card border border-skin-input cursor-default leading-5 rounded-md">
                        {!! __('pagination.next') !!}
                    </span>
                @endif
            </span>
        </nav>
    @endif
</div>
