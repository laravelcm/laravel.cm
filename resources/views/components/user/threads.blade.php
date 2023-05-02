@props(['user', 'threads'])

<div>
    @if($threads->isNotEmpty())
        <div class="space-y-6 sm:space-y-5">
            @foreach ($threads as $thread)
                <x-forum.thread-overview :thread="$thread" />
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
            <div class="text-center max-w-sm mx-auto">
                <svg class="h-10 w-10 text-skin-primary mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <p class="mt-1 text-skin-base text-sm leading-5">{{ __(':name n\'a pas encore posté de Thread', ['name' => $user->name]) }}</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('forum.new')" class="mt-4">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('Nouveau sujet') }}
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
