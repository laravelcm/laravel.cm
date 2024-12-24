<x-container class="py-12">
    <div class="border-b border-gray-200 dark:border-white/20 pb-5">
        <h3 class="font-heading text-3xl font-semibold text-gray-900 dark:text-white">
            {{ __('global.navigation.settings') }}
        </h3>
    </div>

    <section x-data="{ activeTab: 'profile' }" class="relative mt-8 lg:flex lg:gap-12">
        <div class="lg:w-64">
            <x-filament::tabs class="profile-tabs w-full text-nowrap lg:flex-col lg:space-y-2 lg:*:justify-start">
                <x-filament::tabs.item
                    alpine-active="activeTab === 'profile'"
                    x-on:click="activeTab = 'profile'"
                    icon="untitledui-user-02"
                    data-slot="tab"
                >
                    {{ __('global.navigation.profile') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    alpine-active="activeTab === 'password'"
                    x-on:click="activeTab = 'password'"
                    icon="untitledui-lock-keyhole-circle"
                    data-slot="tab"
                >
                    {{ __('global.navigation.password') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    alpine-active="activeTab === 'preferences'"
                    x-on:click="activeTab = 'preferences'"
                    icon="untitledui-sliders-03"
                    data-slot="tab"
                >
                    {{ __('global.navigation.preferences') }}
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    alpine-active="activeTab === 'notifications'"
                    x-on:click="activeTab = 'notifications'"
                    icon="untitledui-bell-04"
                    data-slot="tab"
                >
                    {{ __('global.navigation.notifications') }}
                </x-filament::tabs.item>

                {{--<x-filament::tabs.item
                    alpine-active="activeTab === 'subscription'"
                    x-on:click="activeTab = 'subscription'"
                    icon="untitledui-credit-card-02"
                >
                    {{ __('global.navigation.subscription') }}
                </x-filament::tabs.item>--}}
            </x-filament::tabs>
        </div>
        <div class="mt-10 lg:mt-0 lg:flex-1">
            <div x-show="activeTab === 'profile'">
                <livewire:components.user.profile :user="\Illuminate\Support\Facades\Auth::user()" />
            </div>
            <div x-cloak x-show="activeTab === 'password'">
                <livewire:components.user.password />
            </div>
            <div x-cloak x-show="activeTab === 'preferences'">
                <livewire:components.user.preferences />
            </div>
            <div x-cloak x-show="activeTab === 'notifications'">
                <livewire:components.user.notifications />
            </div>
            <div x-cloak x-show="activeTab === 'subscription'"></div>
        </div>
    </section>
</x-container>
