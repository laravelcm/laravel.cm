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

    <section
        x-data="SlideOver()"
        x-on:close.stop="setShowPropertyTo(false)"
        x-on:keydown.escape.window="closePanelOnEscape()"
        x-show="open"
        class="relative z-50"
        x-ref="dialog"
        aria-modal="true"
        x-cloak
    >
        <div
            x-cloak
            x-show="open"
            x-on:click="closePanelOnClickAway()"
            x-transition:enter="duration-500 ease-in-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="duration-500 ease-in-out"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-800 bg-opacity-75 backdrop-blur-sm transition-opacity"
        ></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div
                        x-cloak
                        x-show="open && showActiveComponent"
                        x-transition:enter="transform transition duration-500 ease-in-out"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition duration-500 ease-in-out"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="pointer-events-auto w-screen p-2"
                        x-bind:class="panelWidth"
                        x-trap.noscroll.inert="open && showActiveComponent"
                        @click.away="closePanelOnClickAway()"
                        aria-modal="true"
                    >
                        <div class="h-full bg-white rounded-xl shadow-xl dark:bg-gray-900">
                            @forelse ($components as $id => $component)
                                <div
                                    class="h-full"
                                    x-show.immediate="activeComponent == '{{ $id }}'"
                                    x-ref="{{ $id }}"
                                    wire:key="{{ $id }}"
                                >
                                    @livewire($component['name'], $component['arguments'], key($id))
                                </div>
                            @empty

                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
