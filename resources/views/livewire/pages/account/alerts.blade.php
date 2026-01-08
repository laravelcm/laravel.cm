<x-layouts.account>
    <div class="space-y-10">
        <div>
            <flux:heading size="lg">{{ __('pages/account.settings.alerts_title') }}</flux:heading>
            <flux:subheading class="mt-1">
                {{ __('pages/account.settings.alerts_description') }}
            </flux:subheading>
        </div>

        <div class="line-y">
            @if ($subscriptions->isNotEmpty())
                <div class="grid border-x border-line sm:grid-cols-2">
                    @foreach ($subscriptions as $subscription)
                        <div class="p-4 flex flex-col justify-between border-b border-line last:border-b-0 sm:border-r sm:even:border-r-0 sm:nth-last-[-n+2]:border-b-0">
                            <div class="flex-1">
                                <button
                                    type="button"
                                    wire:click="redirectToSubscription({{ $subscription->subscribeable_id }}, '{{ $subscription->subscribeable_type }}')"
                                    class="text-base/6 text-left font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                                >
                                    {{ $subscription->subscribeAble?->title }}
                                </button>
                            </div>
                            <div class="mt-3">
                                <flux:button
                                    variant="danger"
                                    size="xs"
                                    class="border-0 px-3"
                                    wire:click="unsubscribe('{{ $subscription->uuid }}')"
                                >
                                    {{ __('pages/forum.unsubscribe_thread') }}
                                </flux:button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-6">
                    <flux:callout icon="clock">
                        <x-slot name="icon">
                            <x-heroicon-o-information-circle class="size-5 text-blue-500" aria-hidden="true" />
                        </x-slot>

                        <flux:callout.heading>
                            {{ __('pages/account.settings.notification.tip') }}
                        </flux:callout.heading>

                        <flux:callout.text>
                            {{ __('pages/account.settings.notification.first_text') }}
                            <span class="font-medium text-gray-900 dark:text-white">"{{ __('pages/account.settings.notification.subscribe') }}"</span>
                            {{ __('pages/account.settings.notification.second_text') }}
                        </flux:callout.text>
                    </flux:callout>
                </div>
            @endif
        </div>
    </div>
</x-layouts.account>
