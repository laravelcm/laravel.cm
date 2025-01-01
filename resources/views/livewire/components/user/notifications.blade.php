<div>
    <x-setting-heading
        :title="__('pages/account.settings.notifications_title')"
        :description="__('pages/account.settings.notifications_description')"
    />

    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
        @forelse ($subscriptions as $subscription)
            <div>
                <div class="bg-white rounded-lg px-4 py-3 dark:bg-gray-800">
                    <button
                        wire:click="redirectToSubscription({{ $subscription->subscribeable_id }}, '{{ $subscription->subscribeable_type }}')"
                        class="text-base/6 text-left font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                    >
                        {{ $subscription->subscribeAble?->title }}
                    </button>
                    <div class="mt-3">
                        <button
                            wire:click="unsubscribe('{{ $subscription->uuid }}')"
                            type="button"
                            class="inline-flex items-start rounded-lg bg-red-100 px-2.5 py-1.5 text-xs font-medium leading-4 text-red-600 hover:bg-red-50"
                        >
                            {{ __('pages/forum.unsubscribe_thread') }}
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="grid max-w-4xl sm:col-span-2 lg:col-span-3">
                <div class="flex px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
                    <div class="shrink-0">
                        <x-heroicon-o-information-circle class="size-5 text-blue-500" aria-hidden="true" />
                    </div>
                    <div class="ml-3 flex-1 font-normal text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-blue-500">{{ __('pages/account.settings.notification.tip') }}</span>
                        {{ __('pages/account.settings.notification.first_text') }}
                        <span class="font-medium text-gray-900">"{{ __('pages/account.settings.notification.subscribe') }}"</span>
                        {{ __('pages/account.settings.notification.second_text') }}
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
