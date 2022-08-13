<div class="{{ $attributes->get('container-class') }}">
    <div class="relative {{ $attributes->get('container-input-class') }}">
        @include('partials._leading-addons')

        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            @if ($value)value="{{ $value }}"@endif
            @if ($errors->has($name))aria-invalid="true"@endif
            {{ $attributes->class([
                'bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green block w-full placeholder-skin-input focus:outline-none focus:placeholder-skin-input-focus text-skin-base sm:text-sm border-skin-input rounded-md',
                'flex-1 block w-full min-w-0 rounded-none rounded-r-md' => $attributes->get('leading-addon'),
                'pl-16 sm:pl-14' => $attributes->get('inline-addon'),
                'pl-10' => $attributes->get('leading-icon') || $attributes->get('isPhone'),
                'border-red-300 text-red-500 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500' => $errors->has($name),
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
