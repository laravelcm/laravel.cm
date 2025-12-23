<?php

declare(strict_types=1);

use App\Actions\GetGithubRepositoriesAction;

use function Livewire\Volt\{computed};

$repositories = computed(fn () => app()->call(GetGithubRepositoriesAction::class));

?>

<div class="section-gradient">
    <div class="line-b">
        <x-container class="px-6 py-2 border-x border-line">
            <div class="inline-flex items-center gap-4">
                <x-icon.tags.open-source class="size-4" aria-hidden="true" />
                <p class="text-gray-700 text-xs font-mono uppercase dark:text-gray-300">
                    {{ __('Open source') }}
                </p>
            </div>
        </x-container>
    </div>
    <x-container class="relative px-0">
        <div class="py-12 px-6">
            <p class="font-heading text-xl font-bold max-w-2xl text-gray-900 dark:text-white lg:text-3xl">
                {{ __('global.community_oss_description') }}
            </p>
        </div>
        <div class="grid line-t border-x border-line divide-x divide-y divide-dotted divide-gray-300 dark:divide-white/20 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($this->repositories->sortByDesc('stargazers_count') as $repository)
                <x-repository :$repository />
            @endforeach
        </div>
    </x-container>
</div>
