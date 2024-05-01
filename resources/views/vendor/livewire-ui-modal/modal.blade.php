<div>
    @isset($jsPath)
        <script>
            {!! file_get_contents($jsPath) !!}
        </script>
    @endisset

    @isset($cssPath)
        <style>
            {!! file_get_contents($cssPath) !!}
        </style>
    @endisset

    <div
        x-data="LivewireUIModal()"
        x-init="init()"
        x-on:close.stop="show = false"
        x-on:keydown.escape.window="closeModalOnEscape()"
        x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
        x-show="show"
        class="fixed inset-0 z-40 overflow-y-auto"
        style="display: none"
    >
        <div class="flex min-h-screen items-end justify-center px-4 pb-10 pt-4 text-center sm:block sm:p-0">
            <div
                x-show="show"
                x-on:click="closeModalOnClickAway()"
                x-transition:enter="duration-300 ease-out"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="duration-200 ease-in"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transform transition-all"
            >
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

            <div
                x-show="show && showActiveComponent"
                x-transition:enter="duration-300 ease-out"
                x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave="duration-200 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                x-bind:class="modalWidth"
                class="inline-block w-full transform overflow-hidden rounded-lg bg-skin-card text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:align-middle"
            >
                @forelse ($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}">
                        @livewire($component['name'], $component['attributes'], key($id))
                    </div>
                @empty
                    
                @endforelse
            </div>
        </div>
    </div>
</div>
