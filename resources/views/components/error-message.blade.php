@if (session('error'))

    <div {{ $attributes->twMerge(['class' => 'rounded-md bg-red-50 p-4']) }}>
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-x class="h-5 w-5 text-red-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">
                    {{ session('error') }}
                </h3>
            </div>
        </div>
    </div>

@endif
