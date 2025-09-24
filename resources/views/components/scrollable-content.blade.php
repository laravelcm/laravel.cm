<div
    x-data="{
        displayLeftArrow: false,
        displayRightArrow: true,
        scrollableId: $id('scrollable'),
        element: null,
        currentTab: null,

        init() {
            this.element = this.$refs.slider
            this.currentTab = this.element.querySelector('.current')

            this.scrollToActive()
        },
        slideLeft() {
            this.element.scrollLeft -= 100
            this.onScroll()
        },
        slideRight() {
            this.element.scrollLeft += 100
            this.onScroll()
        },
        onScroll() {
            this.displayLeftArrow = this.element.scrollLeft >= 20
            let maxScrollPosition =
                this.element.scrollWidth - this.element.clientWidth - 20
            this.displayRightArrow = this.element.scrollLeft <= maxScrollPosition
        },
        scrollToActive() {
            if (this.currentTab) {
                this.element.scrollLeft = this.currentTab.offsetLeft - 50
            }
        },
    }"
    {{ $attributes->twMerge(['class' => 'relative overflow-hidden']) }}
>
    <div
        x-cloak
        x-show="displayLeftArrow"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-x-2 opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition duration-300 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="-translate-x-2 opacity-0"
        class="absolute top-0 flex h-full w-32 items-center justify-start bg-gradient-to-r from-white px-2.5 dark:from-gray-800"
    >
        <button
            @click="slideLeft()"
            type="button"
            class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-500"
        >
            <x-untitledui-chevron-left class="size-6" aria-hidden="true" />
        </button>
    </div>

    <div
        @scroll="onScroll()"
        @class([
            'hide-scroll -mb-px overflow-x-auto scroll-smooth pb-2 pl-4 pr-10',
            $attributes->get('tab-class'),
        ])
        x-ref="slider"
        :id="$id(scrollableId)"
    >
        {{ $slot }}
    </div>

    <div
        x-show="displayRightArrow"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-x-2 opacity-0"
        x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition duration-300 ease-in"
        x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-2 opacity-0"
        class="absolute right-0 top-0 flex h-full w-32 items-center justify-end bg-gradient-to-l from-white px-2.5 dark:from-gray-800"
    >
        <button
            @click="slideRight()"
            type="button"
            class="flex size-8 items-center justify-center rounded-full text-gray-400 transition duration-200 ease-in-out hover:bg-gray-50 focus:outline-hidden dark:bg-gray-800 dark:text-gray-500"
        >
            <x-untitledui-chevron-right class="size-6" aria-hidden="true" />
        </button>
    </div>
</div>
