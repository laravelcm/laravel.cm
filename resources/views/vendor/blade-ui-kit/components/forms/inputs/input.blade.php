<div class="{{ $attributes->get('container-class') }}">
    <div class="{{ $attributes->get('container-input-class') }} relative">
        @include('partials._leading-addons')

        <input
            name="{{ $name }}"
            type="{{ $type }}"
            id="{{ $id }}"
            @if ($value)value="{{ $value }}"@endif
            @if ($errors->has($name))aria-invalid="true"@endif
            {{
                $attributes->class([
                    'block w-full rounded-md border-skin-input bg-skin-input text-gray-500 dark:text-gray-400 placeholder-skin-input shadow-sm focus:border-flag-green focus:placeholder-skin-input-focus focus:outline-none focus:ring-flag-green sm:text-sm',
                    'block w-full min-w-0 flex-1 rounded-none rounded-r-md' => $attributes->get('leading-addon'),
                    'pl-16 sm:pl-14' => $attributes->get('inline-addon'),
                    'pl-10' => $attributes->get('leading-icon') || $attributes->get('isPhone'),
                    'border-red-300 text-red-500 placeholder-red-300 focus:border-red-500 focus:outline-none focus:ring-red-500' => $errors->has($name),
                ])
            }}
        />

        @if ($errors->has($name))
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                <x-untitledui-alert-triangle class="size-5 text-red-500" />
            </div>
        @endif
    </div>

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-500">{{ $error }}</p>
        @endforeach
    @endif
</div>
