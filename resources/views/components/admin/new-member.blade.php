@props(['user'])

<a href="{{ route('profile', ['username' => $user->username]) }}" class="flex items-start">
    <span class="inline-block relative">
      <img class="h-8 w-8 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
      <span class="absolute bottom-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-green-500"></span>
    </span>
    <div class="ml-3">
        <h4 class="font-medium text-sm leading-5 text-skin-inverted-muted">{{ $user->name }}</h4>
        <span class="text-sm leading-5 text-skin-muted">{{ __('Membre depuis :date', ['date' => ucfirst($user->created_at->isoFormat('MMMM YYYY'))]) }}</span>
    </div>
</a>
