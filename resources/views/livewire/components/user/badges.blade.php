<div>
    <div class="mt-5 space-y-4">
        @foreach ($this->badges as $badge)
            <div wire:key="{{ $badge->id }}" class="rounded-xl p-5 bg-white transition duration-200 ease-in-out ring-1 ring-gray-200/50 dark:bg-gray-800 dark:ring-white/10 dark:hover:bg-white/10">
                <div class="flex justify-between gap-3">
                    <div class="flex items-center gap-2 flex-1">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            @if ($this->user->hasBadge())
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                <span class="text-gray-400 opacity-50">?</span>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold {{ $this->user->hasBadge() ? 'text-gray-900' : 'text-gray-400' }}">
                                {{ (new $badge)->name }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                {{ (new $badge)->description }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if (!$this->user->hasBadge())
                            <span class="text-xs text-gray-400">Not unlocked</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
