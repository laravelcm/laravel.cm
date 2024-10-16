<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <nav class="justify-between px-4 py-4 sm:flex sm:items-center sm:px-6">
        <div class="flex items-center space-x-3 divide-x divide-skin-light">
            <a
                href="{{ route('articles') }}"
                class="flex items-center font-sans text-base font-medium text-primary-600 hover:text-primary-600-hover"
            >
                <x-heroicon-o-chevron-left class="mr-1.5 size-5" />
                {{ __('Tous les articles') }}
            </a>
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center pl-3 font-sans text-base font-medium text-gray-500 dark:text-gray-400"
            >
                {{ __('Mes articles') }}
            </a>
        </div>
        <div class="mt-3 flex items-center space-x-2 sm:mt-0">
            @hasanyrole('admin|moderator')
                <x-buttons.primary type="button" wire:click="store">
                    <x-loader class="text-white" wire:loading wire:target="store" />
                    {{ isset($article) ? __('Enregistrer') : __('Publier') }}
                </x-buttons.primary>
            @else
                @if (isset($article))
                    <span class="relative z-20 inline-flex rounded-md shadow-sm">
                        <button
                            type="button"
                            class="button inline-flex items-center justify-center rounded-l-md border-r border-white bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                            disabled
                        >
                            {{ __('Enregistrer') }}
                        </button>
                        <span
                            x-data="{ open: false }"
                            @keydown.escape.stop="open = false;"
                            @click.away="open = false"
                            class="relative -ml-px block"
                        >
                            <button
                                type="button"
                                class="relative inline-flex items-center rounded-r-md border border-transparent bg-green-600 px-2 py-2 text-sm font-medium text-white text-white hover:bg-green-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                                id="option-menu-button"
                                x-ref="button"
                                @click="open = !open"
                                aria-expanded="false"
                                aria-haspopup="true"
                                x-bind:aria-expanded="open.toString()"
                            >
                                <span class="sr-only">{{ __('Ouvrir les options') }}</span>
                                <x-heroicon-s-chevron-down class="size-5" />
                            </button>

                            <div
                                x-show="open"
                                x-transition:enter="transition duration-100 ease-out"
                                x-transition:enter-start="scale-95 transform opacity-0"
                                x-transition:enter-end="scale-100 transform opacity-100"
                                x-transition:leave="transition duration-75 ease-in"
                                x-transition:leave-start="scale-100 transform opacity-100"
                                x-transition:leave-end="scale-95 transform opacity-0"
                                class="absolute right-0 -mr-1 mt-2 w-56 origin-top-right rounded-md bg-skin-card shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                x-ref="menu-items"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="option-menu-button"
                                tabindex="-1"
                                @keydown.tab="open = false"
                                @keydown.enter.prevent="open = false;"
                                @keyup.space.prevent="open = false;"
                                style="display: none"
                            >
                                <div class="py-1" role="none">
                                    <button
                                        type="button"
                                        wire:click="submit"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="option-menu-item-0"
                                    >
                                        <x-loader class="text-white" wire:loading wire:target="submit" />
                                        {{ __('Soumettre') }}
                                    </button>
                                    <button
                                        type="button"
                                        wire:click="store"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="option-menu-item-1"
                                    >
                                        <x-loader class="text-white" wire:loading wire:target="save" />
                                        {{ __('Brouillon') }}
                                    </button>
                                </div>
                            </div>
                        </span>
                    </span>
                @else
                    <x-buttons.default type="button" wire:click="submit">
                        <x-loader class="text-white" wire:loading wire:target="submit" />
                        {{ __('Enregistrer') }}
                    </x-buttons.default>
                @endif
            @endhasanyrole

            <button
                type="button"
                @click="open = true;"
                class="inline-flex justify-center px-4 py-2 text-gray-500 dark:text-gray-400 hover:text-skin-muted focus:outline-none"
            >
                <x-heroicon-o-cog class="size-5" />
            </button>
        </div>
    </nav>

    <div
        x-cloak
        x-show="open"
        class="fixed inset-0 z-20 overflow-hidden"
        aria-labelledby="slide-over-title"
        x-ref="dialog"
        aria-modal="true"
    >
        <div class="absolute inset-0 z-30 overflow-hidden">
            <div class="absolute inset-0" aria-hidden="true">
                <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <div
                        @click.away="open = false;"
                        x-show="open"
                        x-transition:enter="transform transition duration-500 ease-in-out sm:duration-700"
                        x-transition:enter-start="translate-x-full"
                        x-transition:enter-end="translate-x-0"
                        x-transition:leave="transform transition duration-500 ease-in-out sm:duration-700"
                        x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full"
                        class="w-screen max-w-md"
                    >
                        <div class="flex h-full flex-col overflow-y-scroll bg-skin-card py-6 shadow-xl lg:pb-12">
                            <div class="px-4 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                        {{ __('Paramètres avancés') }}
                                    </h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button
                                            type="button"
                                            class="rounded-md bg-skin-card text-skin-muted hover:text-gray-500 dark:text-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-body"
                                            @click="open = false"
                                        >
                                            <span class="sr-only">{{ __('Fermer') }}</span>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="size-6"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                <div class="h-full" aria-hidden="true">
                                    <x-label for="cover_photo">
                                        {{ __('Image de couverture') }}
                                    </x-label>
                                    <div class="mt-2">
                                        <x-forms.single-upload
                                            id="file"
                                            wire:click="removeImage"
                                            wire:model="file"
                                            :file="$file"
                                            :preview="$preview ?? null"
                                            :error="$errors->first('file')"
                                        />
                                    </div>

                                    <div
                                        x-data="{ on: @entangle('show_toc') }"
                                        class="mt-8 flex flex-grow items-center justify-between"
                                    >
                                        <div>
                                            <dt class="text-sm font-semibold leading-7 text-gray-500 dark:text-gray-400">
                                                Afficher le Sommaire
                                            </dt>
                                        </div>
                                        <button
                                            type="button"
                                            class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer items-center rounded-full border border-skin-base bg-skin-card-muted transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                            :class="{ 'bg-green-600': on, 'bg-skin-card-muted': !(on) }"
                                            aria-pressed="false"
                                            x-ref="switch"
                                            x-state:on="Enabled"
                                            x-state:off="Not Enabled"
                                            aria-labelledby="availability-label"
                                            :aria-pressed="on.toString()"
                                            @click="on = !on"
                                        >
                                            <span class="sr-only">Afficher le sommaire</span>
                                            <span
                                                aria-hidden="true"
                                                class="pointer-events-none inline-block size-5 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                                x-state:on="Enabled"
                                                x-state:off="Not Enabled"
                                                :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"
                                            ></span>
                                        </button>
                                    </div>

                                    <div class="mt-8" x-data="datepicker" wire:ignore>
                                        <x-label for="published_at">Date de publication</x-label>
                                        <div class="relative mt-1" wire:model="published_at">
                                            <input
                                                x-ref="datePickerInput"
                                                @click="datePickerOpen =! datePickerOpen"
                                                x-model="datePickerValue"
                                                x-on:keydown.escape="datePickerOpen = false"
                                                id="published_at"
                                                name="published_at"
                                                class="block w-full rounded-md border-skin-input bg-skin-input text-gray-500 dark:text-gray-400 placeholder-skin-input shadow-sm focus:border-flag-green focus:placeholder-skin-input-focus focus:outline-none focus:ring-flag-green sm:text-sm"
                                                type="text"
                                                autocomplete="off"
                                                readonly
                                            />
                                            <button
                                                type="button"
                                                @click="datePickerOpen =! datePickerOpen; if(datePickerOpen) { $refs.datePickerInput.focus() }"
                                                class="absolute right-0 top-0 cursor-pointer px-3 py-2 text-skin-muted hover:text-gray-500 dark:text-gray-400"
                                            >
                                                <svg
                                                    class="size-6"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    />
                                                </svg>
                                            </button>
                                            <div
                                                x-show="datePickerOpen"
                                                x-transition
                                                @click.away="datePickerOpen = false"
                                                class="absolute left-0 top-0 z-50 mt-12 w-[17rem] max-w-lg rounded-lg border border-skin-base bg-skin-body p-4 antialiased shadow"
                                            >
                                                <div class="mb-2 flex items-center justify-between">
                                                    <div>
                                                        <span
                                                            x-text="datePickerMonthNames[datePickerMonth]"
                                                            class="text-lg font-bold text-gray-900"
                                                        ></span>
                                                        <span
                                                            x-text="datePickerYear"
                                                            class="ml-1 text-lg font-normal text-gray-500 dark:text-gray-400"
                                                        ></span>
                                                    </div>
                                                    <div>
                                                        <button
                                                            @click="datePickerPreviousMonth()"
                                                            type="button"
                                                            class="focus:shadow-outline inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-skin-card focus:outline-none"
                                                        >
                                                            <svg
                                                                class="inline-flex size-6 text-skin-muted"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 19l-7-7 7-7"
                                                                />
                                                            </svg>
                                                        </button>
                                                        <button
                                                            @click="datePickerNextMonth()"
                                                            type="button"
                                                            class="focus:shadow-outline inline-flex cursor-pointer rounded-full p-1 transition duration-100 ease-in-out hover:bg-skin-card focus:outline-none"
                                                        >
                                                            <svg
                                                                class="inline-flex size-6 text-skin-muted"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                            >
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 5l7 7-7 7"
                                                                />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-3 grid grid-cols-7">
                                                    <template x-for="(day, index) in datePickerDays" :key="index">
                                                        <div class="px-0.5">
                                                            <div
                                                                x-text="day"
                                                                class="text-center text-xs font-medium text-gray-900/80"
                                                            ></div>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="grid grid-cols-7">
                                                    <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                        <div
                                                            class="border border-transparent p-1 text-center text-sm"
                                                        ></div>
                                                    </template>
                                                    <template
                                                        x-for="(day, dayIndex) in datePickerDaysInMonth"
                                                        :key="dayIndex"
                                                    >
                                                        <div class="aspect-square mb-1 px-0.5">
                                                            <div
                                                                x-text="day"
                                                                @click="datePickerDayClicked(day); $wire.set('published_at', datePickerRealValue)"
                                                                :class="{
                                                                    'bg-skin-card': datePickerIsToday(day) == true,
                                                                    'text-gray-500 dark:text-gray-400 hover:bg-skin-card-gray': datePickerIsToday(day) == false && datePickerIsSelectedDate(day) == false,
                                                                    'bg-primary-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(day) == true
                                                                }"
                                                                class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-full text-center text-sm leading-none"
                                                            ></div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <x-label for="slug">URL Slug</x-label>
                                        <x-input
                                            wire:model.debounce.500ms="slug"
                                            id="slug"
                                            name="slug"
                                            class="mt-1"
                                            type="text"
                                            autocomplete="off"
                                            required
                                        />
                                    </div>

                                    <div class="mt-8">
                                        <x-label for="canonical_url">Canonical URL</x-label>
                                        <span class="text-xs leading-3 text-skin-muted">
                                            Modifiez si l'article a été publié pour la première fois ailleurs (comme sur
                                            votre propre blog).
                                        </span>
                                        <x-input
                                            wire:model="canonical_url"
                                            id="canonical_url"
                                            name="canonical_url"
                                            class="mt-1"
                                            type="text"
                                            autocomplete="off"
                                        />
                                    </div>

                                    <div class="standard mt-8" wire:ignore>
                                        <x-label for="tags_selected">Tags</x-label>
                                        <x-forms.select
                                            wire:model="tags_selected"
                                            id="tags_selected"
                                            class="mt-2"
                                            x-data="{}"
                                            x-init="function () { choices($el) }"
                                            multiple
                                        >
                                            @foreach ($tags as $tag)
                                                <option
                                                    value="{{ $tag->id }}"
                                                    @selected(in_array($tag->id, $tags_selected))
                                                >
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </x-forms.select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="relative z-0 mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:pb-16">
        <x-validation-errors />

        @if (! isset($article))
            <x-rules-banner />
        @endif

        <div class="mt-6">
            <input
                type="text"
                wire:model="title"
                name="title"
                id="title"
                class="block h-auto w-full appearance-none border-0 bg-transparent px-0 py-4 text-3xl font-bold leading-normal text-gray-900 placeholder-skin-input shadow-none focus:placeholder-skin-input-focus focus:ring-0 sm:text-4xl"
                placeholder="Titre de votre article..."
                aria-label="Titre"
                autofocus
                autocomplete="off"
            />
            <livewire:markdown-x :content="$body" />
            <div class="mt-6 text-right text-gray-500 dark:text-gray-400">
                Temps de lecture estimé :
                <span class="text-gray-900">{{ $reading_time }} min</span>
            </div>
        </div>
    </main>
</div>
