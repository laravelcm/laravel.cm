<div class="section-gradient">
    <x-container class="px-0 line-x pt-20 pb-16 lg:pt-28">
        <div class="px-4">
            <h3 class="font-heading text-2xl font-semibold text-gray-900 dark:text-white">
                {{ __('global.navigation.account') }}
            </h3>
        </div>

        <section class="relative mt-8 border-t border-line lg:flex">
            <div class="lg:w-64 lg:border-r lg:border-line">
                <nav class="flex flex-row lg:flex-col lg:space-y-1">
                    <x-nav.forum-link
                        :href="route('account.index')"
                        :active="request()->routeIs('account.index')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-user-02"
                        class="border-t-0"
                    >
                        {{ __('global.navigation.profile') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.password')"
                        :active="request()->routeIs('account.password')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-lock-keyhole-circle"
                    >
                        {{ __('global.navigation.password') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.preferences')"
                        :active="request()->routeIs('account.preferences')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-sliders-03"
                    >
                        {{ __('global.navigation.preferences') }}
                    </x-nav.forum-link>
                    <x-nav.forum-link
                        :href="route('account.alerts')"
                        :active="request()->routeIs('account.alerts')"
                        wire:current="border-line text-gray-900 bg-gray-50 dark:bg-white/10 dark:text-white"
                        icon="untitledui-alarm-clock"
                    >
                        {{ __('global.navigation.alerts') }}
                    </x-nav.forum-link>
                </nav>
            </div>

            <div class="mt-10 px-4 overflow-hidden line-b lg:mt-0 lg:flex-1">
                <div class="lg:max-w-2xl lg:mx-auto lg:py-10">
                    {{ $slot }}
                </div>
            </div>
        </section>
    </x-container>
</div>
