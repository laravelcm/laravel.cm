@props([
    'user',
])

<a href="{{ route('profile', ['username' => $user->username]) }}" class="flex items-start">
    <span class="relative inline-block">
        <img class="size-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
        <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full bg-green-500 ring-2 ring-white"></span>
    </span>
    <div class="ml-3">
        <h4 class="text-sm font-medium leading-5 text-gray-700 dark:text-gray-300">{{ $user->name }}</h4>
        <span class="text-sm leading-5 text-gray-400 dark:text-gray-500">
            {{ __('Membre depuis :date', ['date' => ucfirst($user->created_at->isoFormat('MMMM YYYY'))]) }}
        </span>
    </div>
</a>
