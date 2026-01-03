<div>
    <flux:modal.trigger name="database-notifications">
        <span class="sr-only">{{ __('global.view_notifications') }}</span>
        <span class="relative">
            <x-untitledui-bell class="size-5" aria-hidden="true" />
            <span
                @class([
                    'shadow-solid absolute left-3 -top-1.5 block size-2 rounded-full bg-primary-600 text-white',
                    'hidden' => ! $this->hasNotifications,
                    'block' => $this->hasNotifications,
                ])
            ></span>
        </span>
    </flux:modal.trigger>

    <flux:modal name="database-notifications" flyout variant="floating" class="md:w-lg p-0 flex flex-col flex-1">
        <div class="p-6 space-y-1">
            <flux:heading size="lg">
                {{ __('global.navigation.notifications') }}
                <flux:badge size="sm" class="ml-2">{{ $this->unreadNotificationsCount }}</flux:badge>
            </flux:heading>

            @if ($notifications->isNotEmpty())
                <button
                    type="button"
                    wire:click="markAllAsRead"
                    class="inline-flex items-center text-sm font-medium text-amber-500 hover:underline hover:decoration-1 hover:decoration-dotted dark:text-amber-400 dark:hover:text-amber-500"
                >
                    {{ __('notifications.database.mark_all_as_read_action') }}
                </button>
            @endif
        </div>
        <div class="flex flex-col flex-1 p-1.5 border-t border-line bg-dotted after:border-0">
            <div class="bg-white divide-y divide-gray-200 dark:divide-white/10 flex-1 rounded-lg ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-white/10 overflow-y-auto">
                @forelse ($notifications as $date => $groupedNotifications)
                    <div class="p-4">
                        <flux:text size="sm" class="font-medium text-gray-500 dark:text-gray-400">
                            {{ $date }}
                        </flux:text>
                        <div class="mt-2 space-y-2 divide-y divide-dotted divide-gray-200 dark:divide-white/10">
                            @foreach ($groupedNotifications as $notification)
                                <div class="relative flex gap-3 py-2">
                                    @if (isset($notification->data['author_photo']))
                                        <flux:avatar circle :src="$notification->data['author_photo']" size="sm" />
                                    @else
                                        <div class="size-8 rounded-full bg-primary-600 flex items-center justify-center shrink-0">
                                            <x-untitledui-bell class="size-5 text-white"  aria-hidden="true" />
                                        </div>
                                    @endif

                                    <div class="flex-1 flex items-start gap-2 min-w-0">
                                        <div class="flex-1">
                                            @if ($notification->data['type'] === \App\Enums\NotificationType::Mention->value)
                                                <flux:text size="sm" class="text-gray-900 dark:text-white">
                                                    <strong>{{ $notification->data['author_name'] }}</strong>
                                                    {{ __('notifications.database.mentioned_in') }}
                                                    <strong>{{ $notification->data['replyable_subject'] }}</strong>
                                                </flux:text>
                                            @elseif ($notification->data['type'] === \App\Enums\NotificationType::Reply->value)
                                                <flux:text size="sm" class="text-gray-900 dark:text-white">
                                                    {{ __('notifications.database.new_reply_in') }}
                                                    <strong>{{ $notification->data['replyable_subject'] }}</strong>
                                                </flux:text>
                                            @else
                                                <flux:text size="sm" class="text-gray-900 dark:text-white">
                                                    {{ __('notifications.database.new_notification') }}
                                                </flux:text>
                                            @endif

                                            <flux:text class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </flux:text>
                                        </div>
                                        <button
                                            type="button"
                                            wire:click="markAsRead('{{ $notification->id }}')"
                                            class="inline-flex items-center text-gray-400 dark:text-gray-500 text-sm hover:text-gray-600 dark:hover:text-gray-300"
                                        >
                                            <x-untitledui-check class="size-4" aria-hidden="true" />
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col gap-2 items-center justify-center h-full p-6">
                        <x-untitledui-bell class="size-12 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        <flux:heading size="sm" class="text-gray-900 dark:text-white">
                            {{ __('notifications.database.no_notifications') }}
                        </flux:heading>
                        <flux:text size="sm" class="text-gray-500 dark:text-gray-400 text-center">
                            {{ __('notifications.database.no_notifications_message') }}
                        </flux:text>
                    </div>
                @endforelse
            </div>
        </div>
    </flux:modal>
</div>
