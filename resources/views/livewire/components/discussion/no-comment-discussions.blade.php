<?php

declare(strict_types=1);

use App\Models\Discussion;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    #[Computed(persist: true, seconds: 3600 * 24 * 14, cache: true, key: 'discissions.inactive')]
    public function discussions(): Collection
    {
        return Discussion::with([
            'user:id,username,name,avatar_type',
            'user.media',
        ])
            ->noComments()
            ->limit(5)
            ->get();
    }
} ?>

<div class="bg-white border-t border-line dark:bg-line-black">
    <div class="p-4">
        <h4 class="font-heading font-semibold leading-6 text-gray-900 dark:text-white">
            {{ __('pages/discussion.empty') }}
        </h4>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('pages/discussion.empty_description') }}
        </p>
    </div>
    <div class="border-t border-line">
        <ul role="list" class="divide-y divide-gray-100 dark:divide-white/10">
            @foreach ($this->discussions as $discussion)
                <li class="px-4 py-3">
                    <x-link
                        :href="route('discussions.show', $discussion)"
                        class="text-gray-900 font-medium font-heading text-base/5 hover:underline hover:decoration-1 hover:decoration-primary-400 dark:text-white hover:text-primary-600 dark:hover:text-primary-500"
                    >
                        {{ $discussion->title }}
                    </x-link>
                    <div class="mt-2 flex items-center gap-x-2">
                        <div class="shrink-0">
                            <x-user.avatar :user="$discussion->user" size="xs" />
                        </div>
                        <x-link :href="route('profile', $discussion->user->username)" class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $discussion->user->name }}
                        </x-link>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
