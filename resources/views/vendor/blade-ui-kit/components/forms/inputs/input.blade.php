<div>
    <div class="relative">
        @if ($attributes->get('prefix-icon'))
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                @svg($attributes->get('prefix-icon'), ['class' => 'h-5 w-5 text-gray-400'])
            </div>
        @endif

        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            @if ($value)value="{{ $value }}"@endif
            {{ $attributes->merge([
                'class' => 'bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green block w-full placeholder-skin-input focus:outline-none focus:placeholder-skin-input-focus font-normal text-skin-base sm:text-sm border-skin-input rounded-md' . ($attributes->get('prefix-icon') ? ' pl-10' : '') . ($errors->has($name) ? ' border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' : '')
            ]) }}
        />

        @if ($errors->has($name))
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-500" />
            </div>
        @endif
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-500">{{ $error }}</p>
        @endforeach
    @endif
</div>
