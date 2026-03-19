<x-filament-panels::page>
    @php
        $status = $this->getStatus();
        $isRunning = $status === 'running';
        $isCompleted = $status === 'completed';
        $isFailed = $status === 'failed';
        $isIdle = $status === 'idle';
        $entries = $this->getLogEntries();
        $result = $this->getResult();
        $hasEntries = count($entries) > 0;
        $initEntry = collect($entries)->firstWhere('type', 'init');
    @endphp

    <div
        @if ($isRunning) wire:poll.2s @endif
        x-data="{
            elapsed: 0,
            timer: null,
            startTimer() {
                this.elapsed = 0; this.timer = setInterval(() => this.elapsed++, 1000)
            },
            stopTimer() {
                if (this.timer) clearInterval(this.timer); this.timer = null
            },
            formatTime(s) {
                return s < 60 ? s + 's' : Math.floor(s / 60) + 'm ' + (s % 60) + 's'
            }
        }"
        x-init="@if ($isRunning) startTimer() @endif"
        class="grid h-full grid-cols-1 gap-10 lg:grid-cols-7"
    >
        <div class="space-y-5 lg:col-span-2">
            <flux:select wire:model.live="provider" variant="listbox" label="Provider" placeholder="Choisir un provider">
                @foreach ($this->getAvailableProviders() as $value => $provider)
                    <flux:select.option :value="$value">
                        <div class="flex items-center gap-2">
                            @if ($provider['icon'])
                                <x-icon :name="$provider['icon']" class="size-4 text-gray-400" />
                            @endif
                            {{ $provider['label'] }}
                        </div>
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select wire:model="aiModel" variant="listbox" label="Modele IA" placeholder="Choisir un modele">
                @foreach ($this->getAvailableModels() as $modelId => $modelLabel)
                    <flux:select.option :value="$modelId">
                        <div class="flex items-center gap-2">
                            @if ($this->getModelIcon())
                                <x-icon :name="$this->getModelIcon()" class="size-3.5 text-gray-400" />
                            @endif
                            {{ $modelLabel }}
                        </div>
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:field>
                <flux:label>
                    Taille du batch
                    <x-slot name="trailing">
                        <span wire:text="batchSize" class="tabular-nums"></span>
                    </x-slot>
                </flux:label>
                <flux:slider wire:model="batchSize" min="1" max="10" step="1" />
            </flux:field>

            <flux:separator />

            <div class="bg-gray-50 p-1 ring-1 ring-gray-200 dark:bg-gray-900 dark:ring-white/10 rounded-xl">
                <div class="px-2 py-1.5 flex items-center justify-between">
                    <flux:label>Sources RSS/Atom</flux:label>
                    <flux:button size="xs" variant="subtle" icon="plus" wire:click="addSource">
                        Ajouter
                    </flux:button>
                </div>

                <div class="mt-0.5 bg-white ring-1 ring-gray-200 rounded-lg p-2 dark:bg-gray-950 dark:ring-white/10 space-y-1.5">
                    @foreach ($sources as $index => $source)
                        <div class="flex items-center gap-2" wire:key="source-{{ $index }}">
                            <flux:input
                                wire:model="sources.{{ $index }}"
                                type="url"
                                size="sm"
                                placeholder="https://example.com/feed"
                                class="flex-1"
                            />
                            <flux:button
                                size="xs"
                                variant="danger"
                                icon="trash"
                                wire:click="removeSource({{ $index }})"
                            />
                        </div>
                    @endforeach
                </div>
            </div>

            <flux:button
                variant="primary"
                icon="sparkles"
                wire:click="generate"
                wire:loading.attr="disabled"
                :disabled="$isRunning"
                x-on:click="if (!$el.disabled) startTimer()"
                class="w-full"
            >
                @if ($isRunning)
                    En cours...
                @else
                    <span wire:loading.remove wire:target="generate">Generer</span>
                    <span wire:loading wire:target="generate">Lancement...</span>
                @endif
            </flux:button>
        </div>

        <div class="flex flex-col gap-4 lg:col-span-5">
            @if ($isCompleted && $result)
                <x-filament::callout icon="heroicon-o-check-circle" color="success">
                    <x-slot name="heading">Generation terminee</x-slot>
                    <x-slot name="description">
                        {{ $result['count'] ?? 0 }} article(s) soumis en {{ $result['duration'] ?? 0 }}s
                        via {{ $result['provider'] ?? '' }} / {{ $result['model'] ?? '' }}
                    </x-slot>
                </x-filament::callout>
            @endif

            @if ($isFailed)
                <x-filament::callout icon="heroicon-o-x-circle" color="danger">
                    <x-slot name="heading">Echec de la generation</x-slot>
                    <x-slot name="description">Consultez les logs ci-dessous pour plus de details.</x-slot>
                </x-filament::callout>
            @endif

            <div class="flex-1 rounded-xl ring-1 p-1 ring-gray-200 bg-gray-50 dark:ring-white/10 dark:bg-gray-900">
                <div class="flex items-center justify-between px-4 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">Generation logs</span>
                        @if ($isRunning)
                            <flux:badge size="sm" color="amber">Running</flux:badge>
                        @elseif ($isCompleted)
                            <flux:badge size="sm" color="emerald">Success</flux:badge>
                        @elseif ($isFailed)
                            <flux:badge size="sm" color="red">Failed</flux:badge>
                        @endif
                    </div>
                    @if ($hasEntries)
                        <span class="text-sm tabular-nums text-gray-400" x-text="formatTime(elapsed)"></span>
                    @endif
                </div>

                <div class="bg-white ring-1 ring-gray-200 dark:bg-gray-950 dark:ring-white/10 rounded-lg max-h-[70vh] overflow-y-auto px-5 py-4">
                    @if (! $hasEntries)
                        <div class="flex min-h-80 items-center justify-center">
                            <div class="text-center text-gray-400">
                                <x-phosphor-robot-duotone class="mx-auto mb-3 size-10 text-gray-300 dark:text-gray-600" />
                                <p class="text-sm">Configurez les parametres et lancez la generation</p>
                            </div>
                        </div>
                    @else
                        <flux:timeline align="start">
                            @foreach ($entries as $entry)
                                @php $type = $entry['type'] ?? 'unknown'; @endphp

                                @if ($type === 'init')
                                    @php
                                        $providerKey = $entry['provider'] ?? $this->provider;
                                        $modelIcon = $this->getModelIcon($providerKey);
                                        $providerIcon = $this->getProviderIcon($providerKey);
                                    @endphp
                                    <flux:timeline.item status="complete">
                                        <flux:timeline.indicator variant="bare">
                                            @if ($providerIcon)
                                                <x-icon :name="$providerIcon" class="size-5 text-gray-900 dark:text-white" />
                                            @endif
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <div x-data="{ open: true }">
                                                <div class="flex cursor-pointer items-center justify-between" @click="open = !open">
                                                    <div class="flex items-center gap-2">
                                                        <flux:heading size="sm">Initialisation</flux:heading>
                                                        <x-heroicon-m-chevron-up class="size-3.5 text-gray-400 transition-transform" x-bind:class="!open && 'rotate-180'" />
                                                    </div>
                                                    <span class="text-xs tabular-nums text-gray-400">0.1s</span>
                                                </div>
                                                <div x-show="open" x-collapse class="mt-2 rounded-lg bg-gray-50 py-2 px-4 space-y-1.5 dark:bg-gray-800">
                                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                                                        Provider: <flux:badge size="sm">{{ $providerKey }}</flux:badge>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                                                        Model:
                                                        <flux:badge size="sm" class="gap-1.5">
                                                            @if ($modelIcon)
                                                                <x-icon :name="$modelIcon" class="size-3" />
                                                            @endif
                                                            {{ $entry['model'] ?? '' }}
                                                        </flux:badge>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                                                        Sources: <flux:badge size="sm">{{ $entry['sources'] ?? 0 }}</flux:badge>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400">
                                                        Passes: <flux:badge size="sm">{{ $entry['passes'] ?? 1 }}</flux:badge>
                                                    </div>
                                                </div>
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'pass_start')
                                    @php
                                        $passNum = $entry['pass'] ?? 1;
                                        $totalPasses = $entry['total'] ?? 1;
                                        $passSources = $entry['sources'] ?? [];
                                        $passResultEntry = collect($entries)->first(fn ($e) =>
                                            ($e['type'] ?? '') === 'pass_result' && ($e['pass'] ?? 0) === $passNum
                                        );
                                        $passIsDone = $passResultEntry !== null;
                                        $passIsActive = ! $passIsDone && $isRunning;
                                    @endphp
                                    <flux:timeline.item :status="$passIsDone ? 'complete' : ($passIsActive ? 'current' : 'incomplete')">
                                        @if ($passIsDone)
                                            <flux:timeline.indicator color="green">
                                                <flux:icon.check variant="micro" />
                                            </flux:timeline.indicator>
                                        @elseif ($passIsActive)
                                            <flux:timeline.indicator color="amber">
                                                <flux:icon.arrow-path variant="micro" />
                                            </flux:timeline.indicator>
                                        @else
                                            <flux:timeline.indicator />
                                        @endif
                                        <flux:timeline.content>
                                            <div x-data="{ open: true }">
                                                <div class="flex cursor-pointer items-center justify-between" @click="open = !open">
                                                    <div class="flex items-center gap-2">
                                                        <flux:heading size="sm">Passe {{ $passNum }}/{{ $totalPasses }}</flux:heading>
                                                        <flux:text class="text-xs">{{ count($passSources) }} source(s)</flux:text>
                                                        <x-heroicon-m-chevron-up class="size-3.5 text-gray-400 transition-transform" x-bind:class="!open && 'rotate-180'" />
                                                    </div>
                                                    @if ($passResultEntry)
                                                        <span class="text-xs tabular-nums text-gray-400">{{ $passResultEntry['elapsed'] ?? 0 }}s</span>
                                                    @endif
                                                </div>
                                                <div x-show="open" x-collapse class="mt-2 rounded-lg bg-gray-50 py-2 px-4 space-y-1 dark:bg-gray-800">
                                                    @foreach ($passSources as $sourceUrl)
                                                        @php
                                                            $sourceResult = collect($entries)->first(fn ($e) =>
                                                                ($e['type'] ?? '') === 'source_result' && ($e['url'] ?? '') === $sourceUrl
                                                            );
                                                            $sourceSuccess = $sourceResult ? ($sourceResult['success'] ?? false) : null;
                                                            $sourceDomain = parse_url($sourceUrl, PHP_URL_HOST) ?: $sourceUrl;
                                                            $sourcePath = parse_url($sourceUrl, PHP_URL_PATH) ?: '';
                                                        @endphp
                                                        <div class="flex items-center gap-1.5 py-1 text-sm text-gray-600 dark:text-gray-400">
                                                            @if ($sourceSuccess === true)
                                                                <x-heroicon-s-check-circle class="size-3.5 shrink-0 text-emerald-500" />
                                                            @elseif ($sourceSuccess === false)
                                                                <x-heroicon-s-x-circle class="size-3.5 shrink-0 text-red-500" />
                                                            @else
                                                                <svg class="size-3.5 shrink-0 animate-spin text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                            @endif
                                                            <span>{{ $sourceDomain }}</span>
                                                            <span class="text-xs text-gray-400">{{ $sourcePath }}</span>
                                                            <span class="flex-1 border-b border-dashed border-gray-300 dark:border-gray-600"></span>
                                                            @if ($sourceSuccess === true)
                                                                <flux:badge size="sm" color="emerald">done</flux:badge>
                                                            @elseif ($sourceSuccess === false)
                                                                <flux:badge size="sm" color="red">failed</flux:badge>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                    @if ($passResultEntry)
                                                        <flux:text class="pt-1 text-xs">{{ $passResultEntry['count'] ?? 0 }} article(s) trouve(s) en {{ $passResultEntry['elapsed'] ?? 0 }}s</flux:text>
                                                    @endif
                                                </div>
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'pause')
                                    <flux:timeline.item status="complete">
                                        <flux:timeline.indicator>
                                            <flux:icon.clock variant="micro" />
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <div class="bg-white ring-1 ring-gray-200 py-2 px-4 rounded-lg shadow-xs dark:bg-gray-800 dark:ring-white/10">
                                                <flux:text>Pause de {{ $entry['seconds'] ?? 0 }}s entre les passes</flux:text>
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'saving')
                                    @php
                                        $articleEntries = collect($entries)->where('type', 'article_saved');
                                    @endphp
                                    <flux:timeline.item status="complete">
                                        <flux:timeline.indicator color="green">
                                            <flux:icon.check variant="micro" />
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <div x-data="{ open: true }">
                                                <div class="flex cursor-pointer items-center justify-between" @click="open = !open">
                                                    <div class="flex items-center gap-2">
                                                        <flux:heading size="sm">Sauvegarde</flux:heading>
                                                        <flux:text class="text-xs">{{ $entry['count'] ?? 0 }} article(s)</flux:text>
                                                        <x-heroicon-m-chevron-up class="size-3.5 text-gray-400 transition-transform" x-bind:class="!open && 'rotate-180'" />
                                                    </div>
                                                </div>
                                                <div x-show="open" x-collapse class="mt-2 rounded-lg bg-gray-50 py-2 px-4 space-y-1 dark:bg-gray-800">
                                                    @foreach ($articleEntries as $articleEntry)
                                                        <div class="flex items-center gap-1.5 py-1 text-sm text-gray-600 dark:text-gray-400">
                                                            <x-phosphor-pencil-line-duotone class="size-3.5 shrink-0 text-gray-400" />
                                                            {{ $articleEntry['title'] ?? 'Sans titre' }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'complete')
                                    <flux:timeline.item status="complete">
                                        <flux:timeline.indicator color="green">
                                            <flux:icon.check variant="micro" />
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <div class="flex flex-1 items-center justify-between">
                                                <flux:heading size="sm" class="text-emerald-600 dark:text-emerald-400">Termine — {{ $entry['count'] ?? 0 }} article(s) soumis</flux:heading>
                                                <span class="text-xs tabular-nums text-gray-400">{{ $entry['duration'] ?? 0 }}s total</span>
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'error')
                                    <flux:timeline.item status="current">
                                        <flux:timeline.indicator color="red">
                                            <flux:icon.exclamation-triangle variant="micro" />
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <div class="flex flex-1 items-center justify-between">
                                                <flux:text class="text-red-600 dark:text-red-400">{{ $entry['message'] ?? 'Erreur inconnue' }}</flux:text>
                                                @if (isset($entry['elapsed']))
                                                    <span class="text-xs tabular-nums text-gray-400">{{ $entry['elapsed'] }}s</span>
                                                @endif
                                            </div>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'fatal')
                                    <flux:timeline.item status="current">
                                        <flux:timeline.indicator color="red">
                                            <flux:icon.x-mark variant="micro" />
                                        </flux:timeline.indicator>
                                        <flux:timeline.content>
                                            <flux:heading size="sm" class="text-red-600 dark:text-red-400">{{ $entry['message'] ?? 'Erreur fatale' }}</flux:heading>
                                        </flux:timeline.content>
                                    </flux:timeline.item>

                                @elseif ($type === 'pass_result' || $type === 'source_result' || $type === 'article_saved')

                                @endif
                            @endforeach

                            @if ($isRunning)
                                <flux:timeline.item status="current">
                                    <flux:timeline.indicator variant="bare">
                                        <flux:icon.loading class="size-5 text-amber-500" />
                                    </flux:timeline.indicator>
                                    <flux:timeline.content>
                                        <flux:text class="text-amber-600 dark:text-amber-400">En attente...</flux:text>
                                    </flux:timeline.content>
                                </flux:timeline.item>
                            @endif
                        </flux:timeline>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
