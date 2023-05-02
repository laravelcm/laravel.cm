@props(['user', 'discussions'])

<div>
    @if($discussions->isNotEmpty())
        <div class="-mt-6 relative divide-y divide-skin-base z-20">
            @foreach($discussions as $discussion)
                <x-discussions.overview :discussion="$discussion" :hiddenAuthor="true" />
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
            <div class="text-center max-w-sm mx-auto">
                <svg class="h-10 w-10 text-skin-primary mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                <p class="mt-1 text-skin-base text-sm leading-5">{{ __(':name n\'a pas encore posté de discussions', ['name' => $user->name]) }}</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('discussions.new')" class="mt-4">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('Nouvelle discussion') }}
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
