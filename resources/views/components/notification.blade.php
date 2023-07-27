<div
    x-data="{
        title: '',
        status: 'success',
        messages: [],
        remove(message) {
            this.messages.splice(this.messages.indexOf(message), 1)
        },
    }"
    x-on:notify.window="let message = $event.detail.message; messages.push(message); title = $event.detail.title; status = $event.detail.status; setTimeout(() => { remove(message) }, 5000)"
    class="fixed z-30 inset-0 flex flex-col items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:justify-start space-y-4"
>
    <template x-for="(message, messageIndex) in messages" :key="messageIndex" hidden>
        <div
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
            x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="max-w-sm w-full bg-skin-card shadow-lg rounded-lg pointer-events-auto"
        >
            <div class="rounded-lg shadow-xs overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <x-heroicon-o-check-circle class="h-6 w-6 text-green-400" x-show="status === 'success'" />
                            <x-untitledui-x-circle class="h-6 w-6 text-red-400" x-show="status === 'error'" />
                        </div>
                        <div class="ml-3 w-0 flex-1 pt-0.5">
                            <p x-text="title" class="text-sm leading-5 font-medium text-skin-inverted"></p>
                            <p x-text="message" class="mt-1 text-sm leading-5 font-medium text-skin-base"></p>
                        </div>
                        <div class="ml-4 shrink-0 flex">
                            <button @click="remove(message)" class="inline-flex text-skin-muted focus:outline-none focus:text-skin-base">
                                <x-untitledui-x class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
