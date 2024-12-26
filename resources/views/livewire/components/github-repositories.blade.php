<?php

declare(strict_types=1);

use App\Actions\GetGithubRepositoriesAction;

use function Livewire\Volt\{computed};

$repositories = computed(fn () => app()->call(GetGithubRepositoriesAction::class));

?>

<x-container class="relative py-12 space-y-12 lg:py-20 lg:space-y-16">
    <div>
        <div class="shrink-0 flex items-center gap-2">
            <span
                class="inline-flex items-center justify-center rounded-full p-2 ring-1 ring-black/5 dark:ring-white/10"
            >
                <x-icon.tags.open-source class="size-6" aria-hidden="true" />
            </span>
            <h2 class="font-heading font-bold text-zinc-900 text-2xl dark:text-white lg:text-3xl">Open source</h2>
        </div>
        <p class="mt-4 max-w-2xl text-gray-500 dark:text-gray-400">
            {{ __('global.community_oss_description') }}
        </p>
    </div>
    <div class="grid grid-cols-1 gap-x-12 gap-y-16 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($this->repositories->sortByDesc('stargazers_count') as $repository)
            <x-repository :repository="$repository" />
        @endforeach
    </div>
</x-container>
