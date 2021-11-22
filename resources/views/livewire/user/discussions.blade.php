<div>
    @if($discussions->isNotEmpty())
        <div class="-mt-6 relative divide-y divide-skin-base z-20">
            @foreach($discussions as $discussion)
                <x-discussions.overview :discussion="$discussion" />
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-between rounded-md border border-skin-base border-dashed py-8 px-6">
            <div class="text-center max-w-sm mx-auto">
                <x-heroicon-o-chat class="h-10 w-10 text-skin-primary mx-auto" />
                <p class="mt-1 text-skin-base text-sm leading-5">{{ $user->name }} n'a pas encore posté de discussions</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('discussions.new')" class="mt-4">
                        <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                        Nouvelle discussion
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
