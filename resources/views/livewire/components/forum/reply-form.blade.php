<div x-data="{ open: @entangle('show').live }" class="relative mt-10 lg:mt-16">
    <div class="flex items-center justify-center">
        <div class="w-full max-w-3xl mx-auto">
            <button type="button" @click="open = true" class="relative bg-white rounded-xl px-6 py-5 ring-1 ring-gray-200/60 flex items-center w-full gap-5 hover:ring-gray-300 dark:ring-white/20 dark:hover:ring-white/10 dark:bg-gray-800 dark:hover:bg-white/10 focus:outline-hidden transition duration-200 ease-in-out">
                <x-user.avatar
                    :user="\Illuminate\Support\Facades\Auth::user()"
                    class="size-10 ring-4 ring-white dark:ring-white/20"
                    span="-right-1 size-3.5 -top-1"
                />
                <span class="text-sm leading-6 text-gray-500 dark:text-gray-300">
                    {{ __('pages/forum.reply_message') }}
                </span>
            </button>
            <div class="mt-5 text-center">
                <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                    {{ __('pages/forum.prevent_text_one') }}
                    <x-link :href="route('rules')" class="font-medium text-primary-600 hover:text-primary-500">
                        {{ __('pages/forum.rules') }}
                    </x-link>
                    {{ __('pages/forum.prevent_text_two') }}
                </p>
            </div>
        </div>
    </div>

    <div
        x-cloak
        x-show="open"
        class="fixed inset-x-0 bottom-0 z-10 w-screen overflow-y-auto"
        x-ref="dialog"
        aria-modal="true"
    >
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-lg ring-1 ring-gray-200/60 bg-white dark:ring-white/10 dark:bg-gray-900 text-left shadow-xl transition-all sm:my-4 sm:w-full sm:max-w-3xl"
            >
                <form wire:submit="save" class="flex h-full flex-col divide-y divide-gray-200/60 dark:divide-white/10">
                    <div class="flex items-center px-4 py-3 gap-2">
                        <x-untitledui-corner-up-right class="size-4 text-gray-400 dark:text-gray-500" aria-hidden="true" />
                        <span class="font-medium text-sm text-gray-700 dark:text-gray-300 truncate">
                            {{ __('Répondre au sujet') }}
                        </span>
                        <code class="text-xs py-1 px-1.5 rounded-md bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                            {{ $thread->title }}
                        </code>
                    </div>
                    <div class="h-0 max-h-96 flex-1 overflow-y-auto px-4 py-6">
                        {{ $this->form }}
                    </div>
                    <div class="flex items-center justify-between gap-4 p-4">
                        <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                            {{ __('pages/forum.torchlight') }}
                            <a href="https://torchlight.dev/docs/overview" target="_blank" class="font-medium text-primary-600 underline hover:text-primary-500">
                                Torchlight
                            </a>
                        </p>
                        <div class="flex shrink-0 justify-end gap-4">
                            <x-buttons.default wire:click="close" type="button" class="sm:w-auto">
                                {{ __('actions.cancel') }}
                            </x-buttons.default>
                            <x-buttons.submit
                                wire.loading.attr="data-loading"
                                :title="__('actions.save')"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
