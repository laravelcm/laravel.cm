@if (session('status'))

    <div {{ $attributes->merge(['class' => 'rounded-md bg-green-50 p-4']) }}>
        <div class="flex">
            <div class="shrink-0">
                <x-heroicon-s-check-circle class="h-5 w-5 text-green-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    </div>

@endif
