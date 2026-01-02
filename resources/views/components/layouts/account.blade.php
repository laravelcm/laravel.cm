<div class="section-gradient">
    <x-container class="px-0 pt-20 pb-16 lg:pt-28 lg:line-x">
        <div class="px-4">
            <h3 class="font-heading text-2xl font-semibold text-gray-900 dark:text-white">
                {{ __('global.navigation.account') }}
            </h3>
        </div>

        <section class="relative mt-8 lg:border-t lg:border-line lg:flex">
            <div class="border-y border-line overflow-hidden lg:w-64 lg:border-y-0 lg:border-r">
                <nav class="flex flex-row overflow-x-scroll lg:flex-col lg:space-y-1">
                    <x-nav.forum-link
                        :href="route('account.index')"
                        :active="request()->routeIs('account.index')"
                        icon="untitledui-user-02"
                        class="border-y-0 lg:border-b"
                    >
                        {{ __('global.navigation.profile') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.password')"
                        :active="request()->routeIs('account.password')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-lock-keyhole-circle"
                        class="border-y-0 lg:border-y"
                    >
                        {{ __('global.navigation.password') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.preferences')"
                        :active="request()->routeIs('account.preferences')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-sliders-03"
                        class="border-y-0 lg:border-y"
                    >
                        {{ __('global.navigation.preferences') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.alerts')"
                        :active="request()->routeIs('account.alerts')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-alarm-clock"
                        class="border-y-0 lg:border-y"
                    >
                        {{ __('global.navigation.alerts') }}
                    </x-nav.forum-link>
                </nav>
            </div>

            <div class="mt-4 px-4 overflow-hidden line-b lg:mt-0 lg:flex-1">
                <div class="py-10 lg:max-w-2xl lg:mx-auto">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </x-container>
</div>
