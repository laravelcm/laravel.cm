@if ($attributes->get('leading-addon'))
    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-skin-input bg-skin-card text-skin-base sm:text-sm">
        {!! $attributes->get('leading-addon') !!}
    </span>
@elseif ($attributes->get('inline-addon'))
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-gray-500 sm:text-sm">
            {!! $attributes->get('inline-addon') !!}
        </span>
    </div>
@elseif ($attributes->get('leading-icon'))
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        @svg($attributes->get('leading-icon'), ['class' => 'h-5 w-5 text-skin-muted'])
    </div>
@endif
