<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

use function Livewire\Volt\{computed};

$topContributors = computed(fn (): Collection => User::with('media')
    ->select('id', 'username', 'name', 'avatar_type')
    ->scopes('topContributors')
    ->limit(5)
    ->get()
    ->filter(fn (User $contributor): bool => $contributor->discussions_count >= 1)
)->persist(seconds: 3600 * 24 * 30);

?>

<div class="bg-white dark:bg-line-black">
    <div class="p-4">
        <h4 class="font-heading font-semibold leading-6 text-gray-900 dark:text-white">
            {{ __('pages/discussion.contributors.top') }}
        </h4>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/discussion.contributors.description') }}
        </p>
    </div>
    <div class="border-y border-line">
        <ul role="list" class="divide-y divide-gray-100 dark:divide-white/10">
            @foreach ($this->topContributors as $contributor)
                <li class="px-4 py-3">
                    <div class="flex items-start gap-x-4">
                        <x-link
                            :href="route('profile', $contributor->username)"
                            class="flex min-w-0 flex-1 items-center"
                        >
                            <div class="shrink-0">
                                <x-user.avatar :user="$contributor" size="sm" />
                            </div>
                            <div class="ml-3.5 text-sm">
                                <p class="truncate font-medium text-gray-900 dark:text-white">
                                    {{ $contributor->name }}
                                </p>
                                <p class="truncate text-gray-500 dark:text-gray-400">
                                    {{ '@' . $contributor->username }}
                                </p>
                            </div>
                        </x-link>
                        <span class="text-sm font-mono proportional-nums text-gray-600 gap-1.5 dark:text-gray-400">
                            {{ $contributor->discussions_count }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
