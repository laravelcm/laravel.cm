<div class="relative">
    <textarea
        name="{{ $name }}"
        id="{{ $id }}"
        rows="{{ $rows }}"
        {{
            $attributes->merge([
                'class' => 'bg-skin-input shadow-sm focus:border-flag-green focus:ring-flag-green mt-1 block w-full text-gray-500 dark:text-gray-400 focus:outline-none sm:text-sm font-normal border-skin-input rounded-md' . ($errors->has($name) ? ' border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : ''),
            ])
        }}
    >
{{ old($name, $slot) }}</textarea
    >

    @if ($errors->has($name))
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
            <x-untitledui-alert-triangle class="size-5 text-red-500" />
        </div>
    @endif

    @if ($errors->has($name))
        @foreach ($errors->get($name) as $error)
            <p class="mt-2 text-sm text-red-500">{{ $error }}</p>
        @endforeach
    @endif
</div>
