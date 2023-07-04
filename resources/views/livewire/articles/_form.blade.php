<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <nav class="sm:flex sm:items-center justify-between py-4 px-4 sm:px-6">
        <div class="flex items-center divide-x divide-skin-light space-x-3">
            <a href="{{ route('articles') }}" class="flex items-center font-sans text-skin-primary text-base font-medium hover:text-skin-primary-hover">
                <x-heroicon-o-chevron-left class="h-5 w-5 mr-1.5" />
                {{ __('Tous les articles') }}
            </a>
            <a href="{{ route('dashboard') }}" class="flex items-center pl-3 font-sans text-skin-base text-base font-medium">
                {{ __('Mes articles') }}
            </a>
        </div>
        <div class="flex items-center space-x-2 mt-3 sm:mt-0">
            @hasanyrole('admin|moderator')
                <x-button type="button" wire:click="store">
                    <x-loader class="text-white" wire:loading wire:target="store" />
                    {{ isset($article) ? __('Enregistrer'): __('Publier') }}
                </x-button>
            @else
                @if(isset($article))
                    <span class="relative z-20 inline-flex shadow-sm rounded-md">
                        <button type="button" class="button inline-flex items-center justify-center py-2 px-4 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500 rounded-l-md border-r border-white" disabled>
                            {{ __('Enregistrer') }}
                        </button>
                        <span x-data="{ open: false }" @keydown.escape.stop="open = false;" @click.away="open = false" class="-ml-px relative block">
                            <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-transparent text-sm font-medium text-white text-white bg-green-600 hover:bg-green-700 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500"
                                    id="option-menu-button"
                                    x-ref="button"
                                    @click="open = !open"
                                    aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()">
                                <span class="sr-only">{{ __('Ouvrir les options') }}</span>
                                <x-heroicon-s-chevron-down class="h-5 w-5" />
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-md shadow-lg bg-skin-card ring-1 ring-black ring-opacity-5 focus:outline-none"
                                 x-ref="menu-items"
                                 role="menu" aria-orientation="vertical" aria-labelledby="option-menu-button" tabindex="-1"
                                 @keydown.tab="open = false" @keydown.enter.prevent="open = false;" @keyup.space.prevent="open = false;" style="display: none;">
                                <div class="py-1" role="none">
                                    <button type="button" wire:click="submit" class="block px-4 py-2 text-sm text-skin-inverted-muted hover:text-skin-inverted" role="menuitem" tabindex="-1" id="option-menu-item-0">
                                        <x-loader class="text-white" wire:loading wire:target="submit" />
                                        {{ __('Soumettre') }}
                                    </button>
                                    <button type="button" wire:click="store" class="block px-4 py-2 text-sm text-skin-inverted-muted hover:text-skin-inverted" role="menuitem" tabindex="-1" id="option-menu-item-1">
                                        <x-loader class="text-white" wire:loading wire:target="save" />
                                       {{ __('Brouillon') }}
                                    </button>
                                </div>
                            </div>
                        </span>
                    </span>
                @else
                    <x-button type="button" wire:click="submit">
                        <x-loader class="text-white" wire:loading wire:target="submit" />
                        {{ __('Enregistrer') }}
                    </x-button>
                @endif
            @endhasanyrole

            <button type="button" @click="open = true;" class="inline-flex justify-center py-2 px-4 text-skin-base hover:text-skin-muted focus:outline-none">
                <x-heroicon-o-cog class="h-5 w-5" />
            </button>
        </div>
    </nav>

    <div x-cloak x-show="open" class="fixed inset-0 z-20 overflow-hidden" aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
        <div class="absolute inset-0 z-30 overflow-hidden">
            <div class="absolute inset-0" aria-hidden="true">
                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div @click.away="open = false;"
                         x-show="open"
                         x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         class="w-screen max-w-md"
                    >
                        <div class="h-full flex flex-col py-6 bg-skin-card shadow-xl overflow-y-scroll lg:pb-12">
                            <div class="px-4 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-skin-inverted" id="slide-over-title">
                                        {{ __('Paramètres avancés') }}
                                    </h2>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button type="button" class="bg-skin-card rounded-md text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500" @click="open = false">
                                            <span class="sr-only">{{ __('Fermer') }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 relative flex-1 px-4 sm:px-6">
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

                                    <div x-data="{ on: @entangle('show_toc') }" class="mt-8 flex-grow flex items-center justify-between">
                                        <div>
                                            <dt class="text-sm leading-7 font-semibold text-skin-base">
                                                {{ __('Afficher le Sommaire') }}
                                            </dt>
                                        </div>
                                        <button type="button"
                                            class="relative inline-flex items-center shrink-0 h-6 w-11 border border-skin-base rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 bg-skin-card-muted"
                                            :class="{ 'bg-green-600': on, 'bg-skin-card-muted': !(on) }"
                                            aria-pressed="false"
                                            x-ref="switch"
                                            x-state:on="Enabled"
                                            x-state:off="Not Enabled"
                                            aria-labelledby="availability-label"
                                            :aria-pressed="on.toString()"
                                            @click="on = !on"
                                        >
                                            <span class="sr-only">{{ __('Afficher le sommaire') }}</span>
                                            <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                        </button>
                                    </div>

                                    <div class="mt-8" x-data="datepicker" wire:ignore>
                                        <x-label for="published_at">{{ __('Date de publication') }}</x-label>
                                        <div class="relative mt-1" wire:model="published_at">
                                            <input
                                                x-ref="datePickerInput"
                                                @click="datePickerOpen =! datePickerOpen"
                                                x-model="datePickerValue"
                                                x-on:keydown.escape="datePickerOpen = false"
                                                id="published_at"
                                                name="published_at"
                                                class="bg-skin-input shadow-sm focus:ring-flag-green focus:border-flag-green block w-full placeholder-skin-input focus:outline-none focus:placeholder-skin-input-focus text-skin-base sm:text-sm border-skin-input rounded-md"
                                                type="text"
                                                autocomplete="off"
                                                readonly
                                            />
                                            <button type="button" @click="datePickerOpen =! datePickerOpen; if(datePickerOpen) { $refs.datePickerInput.focus() }" class="absolute top-0 right-0 px-3 py-2 cursor-pointer text-skin-muted hover:text-skin-base">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                            <div
                                                x-show="datePickerOpen"
                                                x-transition
                                                @click.away="datePickerOpen = false"
                                                class="absolute top-0 left-0 max-w-lg p-4 mt-12 antialiased bg-skin-body border rounded-lg shadow w-[17rem] border-skin-base z-50">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div>
                                                        <span x-text="datePickerMonthNames[datePickerMonth]" class="text-lg font-bold text-skin-inverted"></span>
                                                        <span x-text="datePickerYear" class="ml-1 text-lg font-normal text-skin-base"></span>
                                                    </div>
                                                    <div>
                                                        <button @click="datePickerPreviousMonth()" type="button" class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-skin-card">
                                                            <svg class="inline-flex w-6 h-6 text-skin-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                            </svg>
                                                        </button>
                                                        <button @click="datePickerNextMonth()" type="button" class="inline-flex p-1 transition duration-100 ease-in-out rounded-full cursor-pointer focus:outline-none focus:shadow-outline hover:bg-skin-card">
                                                            <svg class="inline-flex w-6 h-6 text-skin-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-7 mb-3">
                                                    <template x-for="(day, index) in datePickerDays" :key="index">
                                                        <div class="px-0.5">
                                                            <div x-text="day" class="text-xs font-medium text-center text-skin-inverted/80"></div>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="grid grid-cols-7">
                                                    <template x-for="blankDay in datePickerBlankDaysInMonth">
                                                        <div class="p-1 text-sm text-center border border-transparent"></div>
                                                    </template>
                                                    <template x-for="(day, dayIndex) in datePickerDaysInMonth" :key="dayIndex">
                                                        <div class="px-0.5 mb-1 aspect-square">
                                                            <div
                                                                x-text="day"
                                                                @click="datePickerDayClicked(day); $wire.set('published_at', datePickerRealValue)"
                                                                :class="{
                                                                    'bg-skin-card': datePickerIsToday(day) == true,
                                                                    'text-skin-base hover:bg-skin-card-gray': datePickerIsToday(day) == false && datePickerIsSelectedDate(day) == false,
                                                                    'bg-primary-800 text-white hover:bg-opacity-75': datePickerIsSelectedDate(day) == true
                                                                }"
                                                                class="flex items-center justify-center text-sm leading-none text-center rounded-full cursor-pointer h-7 w-7">
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <x-label for="slug">{{ __('URL Slug') }}</x-label>
                                        <x-input wire:model.debounce.500ms="slug" id="slug" name="slug" class="mt-1" type="text" autocomplete="off" required />
                                    </div>

                                    <div class="mt-8">
                                        <x-label for="canonical_url">{{ __('Canonical URL') }}</x-label>
                                        <span class="text-xs leading-3 text-skin-muted">
                                            {{ __('Modifiez si l\'article a été publié pour la première fois ailleurs (comme sur votre propre blog).') }}
                                        </span>
                                        <x-input wire:model.defer="canonical_url" id="canonical_url" name="canonical_url" class="mt-1" type="text" autocomplete="off" />
                                    </div>

                                    <div class="mt-8 standard" wire:ignore>
                                        <x-label for="tags_selected">Tags</x-label>
                                        <x-forms.select wire:model="tags_selected" id="tags_selected" class="mt-2" x-data="{}" x-init="function () { choices($el) }" multiple>
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}" @if(in_array($tag->id, $tags_selected)) selected @endif>{{ $tag->name }}</option>
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

    <main class="relative max-w-4xl mx-auto py-10 z-0 px-4 sm:px-6 lg:px-8 lg:pb-16">
        <x-validation-errors />

        @if(! isset($article))
            <x-rules-banner />
        @endif

        <div class="mt-6">
            <input
                type="text"
                wire:model="title"
                name="title"
                id="title"
                class="block w-full h-auto px-0 py-4 text-3xl sm:text-4xl font-bold placeholder-skin-input focus:placeholder-skin-input-focus font-normal text-skin-inverted bg-transparent border-0 leading-normal border-0 appearance-none focus:ring-0 shadow-none"
                placeholder="Titre de votre article..."
                autofocus
                autocomplete="off"
            />
            <livewire:markdown-x :content="$body" />
            <div class="mt-6 text-right text-skin-base">
                {{ __('Temps de lecture estimé :') }} <span class="text-skin-inverted">{{ $reading_time }} min</span>
            </div>
        </div>
    </main>

</div>
