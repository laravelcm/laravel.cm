@if ($attributes->get('leading-addon'))
    <span
        class="inline-flex items-center rounded-l-md border border-r-0 border-skin-input bg-skin-card px-3 text-skin-base sm:text-sm"
    >
        {!! $attributes->get('leading-addon') !!}
    </span>
@elseif ($attributes->get('inline-addon'))
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <span class="text-gray-500 sm:text-sm">
            {!! $attributes->get('inline-addon') !!}
        </span>
    </div>
@elseif ($attributes->get('leading-icon'))
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        @svg($attributes->get('leading-icon'), ['class' => 'h-5 w-5 text-skin-muted'])
    </div>
@endif
