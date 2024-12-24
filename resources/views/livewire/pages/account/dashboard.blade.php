<x-container class="py-12">
    <header>
        <h1 class="text-xl font-bold leading-7 text-gray-900 dark:text-white sm:truncate sm:text-2xl">
            {{ __('global.navigation.dashboard') }}
        </h1>
        <x-user.stats :user="$this->user" />
    </header>
    <section x-data="{ activeTab: 'articles' }" class="relative mt-8 lg:flex lg:gap-12">
        <div class="lg:w-64">
            <x-filament::tabs class="profile-tabs w-full text-nowrap lg:flex-col lg:space-y-2 lg:*:justify-start ">
                <x-filament::tabs.item
                    alpine-active="activeTab === 'articles'"
                    class="relative"
                    x-on:click="activeTab = 'articles'"
                    icon="untitledui-file-05"
                    data-slot="tab"
                >
                    {{ __('Mes articles') }}
                    <span class="lg:absolute lg:right-5">
                        {{ number_format($this->user->articles->count()) }}
                    </span>
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    alpine-active="activeTab === 'discussions'"
                    class="relative"
                    x-on:click="activeTab = 'discussions'"
                    icon="untitledui-message-chat-square"
                    data-slot="tab"
                >
                    {{ __('Mes discussions') }}
                    <span class="lg:absolute right-5">
                        {{ number_format($this->user->discussions->count()) }}
                    </span>
                </x-filament::tabs.item>

                <x-filament::tabs.item
                    alpine-active="activeTab === 'sujets'"
                    class="relative"
                    x-on:click="activeTab = 'sujets'"
                    icon="untitledui-file-02"
                    data-slot="tab"
                >
                    {{ __('Mes sujets') }}
                    <span class="lg:absolute lg:right-5">
                        {{ number_format($this->user->threads->count()) }}
                    </span>
                </x-filament::tabs.item>
            </x-filament::tabs>
        </div>

        <div class="mt-10 lg:mt-0 lg:flex-1">
            <div x-show="activeTab === 'articles'">
                <livewire:components.account.articles />
            </div>
            <div x-cloak x-show="activeTab === 'discussions'">
                <livewire:components.account.discussions :user="$this->user" lazy />
            </div>
            <div x-cloak x-show="activeTab === 'sujets'">
                <livewire:components.account.threads :user="$this->user" lazy />
            </div>
        </div>
    </section>
</x-container>
