<div
    x-data="{
        title: '',
        status: 'success',
        messages: [],
        remove(message) {
            this.messages.splice(this.messages.indexOf(message), 1)
        },
    }"
    x-on:notify.window="
        let message = $event.detail.message
        messages.push(message)
        title = $event.detail.title
        status = $event.detail.status
        setTimeout(() => {
            remove(message)
        }, 5000)
    "
    class="pointer-events-none fixed inset-0 z-30 flex flex-col items-end justify-center space-y-4 px-4 py-6 sm:justify-start sm:p-6"
>
    <template x-for="(message, messageIndex) in messages" :key="messageIndex" hidden>
        <div
            x-transition:enter="transform transition duration-300 ease-out"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-x-2 sm:translate-y-0"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition duration-100 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="pointer-events-auto w-full max-w-sm rounded-lg bg-skin-card shadow-lg"
        >
            <div class="shadow-xs overflow-hidden rounded-lg">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <x-heroicon-o-check-circle class="size-6 text-green-400" x-show="status === 'success'" />
                            <x-untitledui-x-circle class="size-6 text-red-400" x-show="status === 'error'" />
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p x-text="title" class="text-sm font-medium leading-5 text-gray-900"></p>
                            <p x-text="message" class="mt-1 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400"></p>
                        </div>
                        <div class="ml-4 flex shrink-0">
                            <button
                                @click="remove(message)"
                                class="inline-flex text-skin-muted focus:text-gray-500 dark:text-gray-400 focus:outline-none"
                            >
                                <x-untitledui-x class="size-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
