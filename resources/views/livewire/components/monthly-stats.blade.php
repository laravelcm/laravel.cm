<div>
    <flux:card class="p-1 bg-dotted dark:bg-gray-900 after:border-0">
        <div class="flex items-center justify-between p-2">
            <span class="text-sm text-gray-500 font-medium dark:text-gray-400">{{ $title }}</span>
            @svg($icon, 'size-5 text-gray-500 dark:text-gray-400')
        </div>

        <div class="mt-0.5 bg-white rounded-xl p-3 ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-white/10 flex items-end justify-between gap-4">
            <div>
                <p class="text-2xl font-semibold font-mono slashed-zero tabular-nums text-gray-900 dark:text-white">
                    {{ number_format($this->count) }}
                </p>
                <p class="text-sm mt-1">
                    @if ($this->percentChange >= 0)
                        <span class="text-emerald-500 font-medium">+{{ $this->percentChange }}%</span>
                    @else
                        <span class="text-red-500 font-medium">{{ $this->percentChange }}%</span>
                    @endif
                    <span class="text-gray-400 ml-1 dark:text-gray-500">{{ __('global.vs_last_month') }}</span>
                </p>
            </div>

            @php
                $points = collect($this->sparklineData);
                $max = $points->max();
                $min = $points->min();
                $range = $max - $min ?: 1;
                $coords = $points->map(function ($value, $index) use ($points, $min, $range) {
                    $x = ($index / ($points->count() - 1)) * 100;
                    $y = 40 - (($value - $min) / $range) * 35;
                    return "$x,$y";
                })->implode(' ');
                $strokeColor = $this->percentChange >= 0 ? '#10b981' : '#ef4444';
            @endphp

            <svg class="w-24 h-12" viewBox="0 0 100 40" preserveAspectRatio="none">
                <polyline
                    fill="none"
                    stroke="{{ $strokeColor }}"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    points="{{ $coords }}"
                />
            </svg>
        </div>
    </flux:card>
</div>
