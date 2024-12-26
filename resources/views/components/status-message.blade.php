@if (session('status'))
    <div {{ $attributes->merge(['class' => 'rounded-lg bg-green-50 p-4 dark:bg-green-800/20']) }}>
        <div class="flex">
            <div class="shrink-0">
                <x-heroicon-s-check-circle class="size-5 text-green-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('status') }}
                </p>
            </div>
        </div>
    </div>
@endif
