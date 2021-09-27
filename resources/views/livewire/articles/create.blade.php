<div x-data="{ open: false }" @keydown.window.escape="open = false">
    <nav class="sm:flex sm:items-center justify-between py-4 px-4 sm:px-6">
        <div class="flex items-center divide-x divide-skin-light space-x-3">
            <a href="{{ route('articles') }}" class="flex items-center font-sans text-skin-primary text-base font-medium hover:text-skin-primary-hover">
                <x-heroicon-o-chevron-left class="h-5 w-5 mr-1.5" />
                Tous les articles
            </a>
            <a href="#" class="flex items-center pl-3 font-sans text-skin-base text-base font-medium">Mes articles</a>
        </div>
        <div class="flex items-center space-x-2 mt-3 sm:mt-0">
            @hasanyrole('admin|moderator')
                <x-button type="button" wire:click="store">
                    <x-loader class="text-white" wire:loading wire:target="store" />
                    Publier
                </x-button>
            @else
                <x-button type="button" wire:click="submit">
                    <x-loader class="text-white" wire:loading wire:target="submit" />
                    Soumettre
                </x-button>
            @endhasanyrole
            <x-default-button type="button" wire:click="draft">
                <x-loader class="text-white" wire:loading wire:target="draft" />
                Brouillon
            </x-default-button>
            <button type="button" @click="open = true;" class="inline-flex justify-center py-2 px-4 text-skin-base hover:text-skin-muted focus:outline-none">
                <x-heroicon-o-cog class="h-5 w-5" />
            </button>
        </div>
    </nav>

    <div x-cloak x-show="open" class="fixed inset-0 z-20 overflow-hidden" aria-labelledby="slide-over-title" x-ref="dialog" aria-modal="true">
        <div class="absolute inset-0 z-30 overflow-hidden">
            <div class="absolute inset-0" aria-hidden="true">
                <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                    <div @click.away="open = false;" x-show="open" x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="w-screen max-w-md">
                        <div class="h-full flex flex-col py-6 bg-skin-card shadow-xl overflow-y-scroll">
                            <div class="px-4 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-skin-inverted" id="slide-over-title">
                                        Paramètres avancés
                                    </h2>
                                    <div class="ml-3 h-7 flex items-center">
                                        <button type="button" class="bg-skin-card rounded-md text-skin-muted hover:text-skin-base focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-body focus:ring-green-500" @click="open = false">
                                            <span class="sr-only">Close panel</span>
                                            <x-heroicon-o-x class="h-6 w-6" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 relative flex-1 px-4 sm:px-6">
                                <div class="absolute inset-0 px-4 sm:px-6">
                                    <div class="h-full" aria-hidden="true">
                                        <x-label for="cover_photo">
                                            Image de couverture
                                        </x-label>
                                        <div class="mt-2">
                                            <x-forms.single-upload id="file" wire:click="removeImage" wire:model="file" :file="$file" :error="$errors->first('file')" />
                                        </div>

                                        <div x-data="{ on: @entangle('show_toc') }" class="mt-8 flex-grow flex items-center justify-between">
                                            <div>
                                                <dt class="text-sm leading-7 font-semibold text-skin-base">Afficher le Sommaire</dt>
                                            </div>
                                            <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 bg-skin-card-muted" aria-pressed="false" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-green-600': on, 'bg-skin-card-muted': !(on) }" aria-labelledby="availability-label" :aria-pressed="on.toString()" @click="on = !on">
                                                <span class="sr-only">{{ __('Afficher le sommaire') }}</span>
                                                <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 rounded-full bg-skin-menu shadow transform ring-0 transition ease-in-out duration-200 translate-x-0" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                            </button>
                                        </div>

                                        <div class="mt-8">
                                            <x-label for="slug">URL Slug</x-label>
                                            <x-input wire:model.debounce.500ms="slug" id="slug" name="slug" class="mt-1" type="text" autocomplete="off" required />
                                        </div>

                                        <div class="mt-8">
                                            <x-label for="canonical_url">Canonical URL</x-label>
                                            <span class="text-xs leading-3 text-skin-muted">Modifiez si l'article a été publié pour la première fois ailleurs (comme sur votre propre blog).</span>
                                            <x-input wire:model.defer="canonical_url" id="canonical_url" name="canonical_url" class="mt-1" type="text" autocomplete="off" required />
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
    </div>

    <main class="relative max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 z-0">
        <x-validation-errors />

        <x-rules-banner />

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
            <livewire:markdown-x />
        </div>
    </main>

</div>
