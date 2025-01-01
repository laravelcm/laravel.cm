<div>
    <x-slot:buttons>
        <x-buttons.primary
            type="button"
            onclick="Livewire.dispatch('openPanel', { component: 'components.slideovers.thread-form' })"
            class="gap-2 w-full justify-center py-2.5"
        >
            {{ __('pages/forum.new_thread') }}
            <span class="absolute pointer-events-none right-0 pr-3">
                <x-untitledui-plus class="size-5" aria-hidden="true" />
            </span>
        </x-buttons.primary>
    </x-slot:buttons>

    <div id="leaderboard">
        @if($leaders->isNotEmpty())
            @php
                $first = $leaders->first();
                $second = $leaders->get(1);
                $third = $leaders->last();
            @endphp

            <div class="relative isolate">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-evenly lg:pl-4">
                    <div class="group z-10 order-2 sm:flex sm:flex-col sm:items-center lg:order-1 lg:mt-8">
                        <x-forum.leader :user="$second" :position="2" />
                        <div class="hidden leaderboard w-60 xl:grid">
                            <div class="stage h-12 bg-yellow-300">
                                <div class="stage-front flex items-center justify-center text-white h-24 bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900"></div>
                            </div>
                        </div>
                    </div>
                    <div class="group z-20 order-1 sm:flex sm:flex-col sm:items-center lg:order-2">
                        <x-forum.leader :user="$first" :position="1" />
                        <div class="hidden leaderboard w-90 xl:grid">
                            <div class="stage h-12 bg-green-500">
                                <div class="stage-front flex items-center justify-center text-white h-32 bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900"></div>
                            </div>
                        </div>
                    </div>
                    <div class="group z-10 order-3 sm:flex sm:flex-col sm:items-center lg:mt-8 xl:mt-14">
                        <x-forum.leader :user="$third" :position="3" />
                        <div class="hidden leaderboard w-60 xl:grid">
                            <div class="stage h-12 bg-danger-400">
                                <div class="stage-front flex items-center justify-center text-white h-[4rem] bg-gradient-to-b from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 w-full max-w-sm mx-auto flex items-center justify-center">
                    <div class="relative z-10 flex flex-1 w-full items-center overflow-hidden rounded-lg ring-1 ring-gray-200 p-[1px] dark:ring-white/10">
                        <div
                            class="animate-rotate absolute inset-0 h-full w-full rounded-full bg-[conic-gradient(#e21b30_20deg,transparent_120deg)]"
                        ></div>
                        <div class="flex-1 flex items-center px-4 py-2 rounded-lg bg-white dark:bg-gray-800">
                            <p class="inline-flex items-center gap-2 text-[13px] text-gray-700 dark:text-gray-300">
                                <x-phosphor-trophy-duotone class="size-5" aria-hidden="true" />
                                {{ __('global.ranking_updated') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="relative mt-10">
            <div class="space-y-2">
                <div class="grid auto-cols grid-flow-col bg-white rounded-xl font-medium text-sm text-gray-900 px-4 py-3 ring-1 ring-gray-200 dark:text-white dark:ring-white/10 dark:bg-gray-800">
                    <div class="w-10">
                        {{ __('global.place') }}
                    </div>
                    <div class="w-32">
                        {{ __('global.user') }}
                    </div>
                    <div class="w-24 hidden text-right md:block">
                        {{ __('global.experience') }}
                    </div>
                    <div class="w-20 text-right capitalize">
                        {{ __('global.answers') }}
                    </div>
                    <div class="w-28 text-right hidden lg:block">
                        {{ __('global.last_active') }}
                    </div>
                </div>

                @forelse($members as $user)
                    <div class="grid auto-cols grid-flow-col bg-gray-100 rounded-xl px-4 py-3 text-sm text-gray-700 dark:bg-gray-950/50 dark:text-gray-300">
                        <div class="w-10 flex items-center gap-2">
                            <x-phosphor-trophy-duotone class="size-5" aria-hidden="true" />
                            {{ $loop->index + $startPosition }}
                        </div>
                        <div class="w-32 flex items-center gap-2">
                            <x-user.avatar :user="$user" class="size-7" />
                            <span class="text-gray-500 dark:text-gray-400">
                                {{ '@' . $user->username }}
                            </span>
                        </div>
                        <div class="w-24 hidden text-right md:block">
                            {{ $user->getPoints() }}
                        </div>
                        <div class="w-20 capitalize text-right">
                            {{ $user->solutions_count }}
                        </div>
                        <div class="w-28 text-right hidden lg:block">
                            {{ $user->last_active_at?->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-100 rounded-xl px-4 py-3 text-center text-sm text-gray-700 dark:bg-gray-950/50 dark:text-gray-300">
                        {{ __('pages/forum.leaderboard_empty') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
