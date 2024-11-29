<x-app-layout :title="$user->username .' ( '. $user->name . ')'" :canonical="route('profile', $user->username)">
    <div>
        <x-container class="mx-auto max-w-7xl px-4">
            <div class="-mt-12 sm:-mt-16 sm:flex sm:items-end sm:space-x-5">
                <div class="mt-6 sm:flex sm:min-w-0 sm:flex-1 sm:items-center sm:justify-end sm:space-x-6 sm:pb-1">
                    <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-x-4 sm:space-y-0">
                        @if ($user->isLoggedInUser())
                            <x-buttons.default :href="route('user.settings')">
                                <svg
                                    class="-ml-1 mr-2 size-5 text-gray-400 dark:text-gray-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                                    />
                                </svg>
                                {{ __('Éditer') }}
                            </x-buttons.default>
                        @endif
                    </div>
                </div>
            </div>
        </x-container>
    </div>

    <x-container class="py-10">

        <div class="relative mt-6 border-t border-skin-base pt-6 sm:border-0 sm:pt-0 lg:grid lg:grid-cols-8 lg:gap-12">
            <div
                class="lg:col-span-6"
                x-data="{
                    tabSelected: 1,
                    tabId: $id('tabs'),
                    tabButtonClicked(tabButton) {
                        this.tabSelected = tabButton.id.replace(this.tabId + '-', '')
                        this.tabRepositionMarker(tabButton)
                    },
                    tabRepositionMarker(tabButton) {
                        this.$refs.tabMarker.style.width = tabButton.offsetWidth + 'px'
                        this.$refs.tabMarker.style.height = tabButton.offsetHeight + 'px'
                        this.$refs.tabMarker.style.left = tabButton.offsetLeft + 'px'
                    },
                    tabContentActive(tabContent) {
                        return (
                            this.tabSelected ==
                            tabContent.id.replace(this.tabId + '-content-', '')
                        )
                    },
                }"
                x-init="tabRepositionMarker($refs.tabButtons.firstElementChild)"
            >
                <div class="relative w-full">
                    <div
                        x-ref="tabButtons"
                        class="relative inline-grid h-10 w-full select-none grid-cols-3 items-center justify-center rounded-lg bg-skin-card p-1 text-gray-500 dark:text-gray-400 lg:max-w-md"
                    >
                        <button
                            :id="$id(tabId)"
                            @click="tabButtonClicked($el)"
                            type="button"
                            class="relative z-20 inline-flex h-8 w-full cursor-pointer items-center justify-center whitespace-nowrap rounded-md px-3 text-sm font-medium transition-all"
                        >
                            Articles
                        </button>
                        <button
                            :id="$id(tabId)"
                            @click="tabButtonClicked($el)"
                            type="button"
                            class="relative z-20 inline-flex h-8 w-full cursor-pointer items-center justify-center whitespace-nowrap rounded-md px-3 text-sm font-medium transition-all"
                        >
                            Discussions
                        </button>
                        <button
                            :id="$id(tabId)"
                            @click="tabButtonClicked($el)"
                            type="button"
                            class="relative z-20 inline-flex h-8 w-full cursor-pointer items-center justify-center whitespace-nowrap rounded-md px-3 text-sm font-medium transition-all"
                        >
                            Questions
                        </button>
                        <div x-ref="tabMarker" class="absolute left-0 z-10 h-full w-1/2 duration-300 ease-out" x-cloak>
                            <div class="h-full w-full rounded-md bg-skin-body shadow-sm"></div>
                        </div>
                    </div>

                    <div class="content mt-8">
                        <div x-cloak :id="$id(tabId + '-content')" x-show="tabContentActive($el)">
                            <div
                                class="flex items-center justify-between rounded-md border border-dashed border-skin-base px-6 py-8"
                            >
                                <div class="mx-auto max-w-sm text-center">
                                    <svg
                                        class="mx-auto size-10 text-primary-600"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"
                                        />
                                    </svg>
                                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">
                                        {{ __(':name ne possède aucun badge', ['name' => $user->name]) }}
                                    </p>
                                    <x-buttons.primary href="#" class="mt-4">Voir tous les badges</x-buttons.primary>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
