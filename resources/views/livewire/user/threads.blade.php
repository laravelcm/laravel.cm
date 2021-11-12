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
                <x-heroicon-o-document-add class="h-10 w-10 text-skin-primary mx-auto" />
                <p class="mt-1 text-skin-base text-sm leading-5">{{ $user->name }} n'a pas encore posté de Thread</p>
                @if ($user->isLoggedInUser())
                    <x-button :link="route('forum.new')" class="mt-4">
                        <x-heroicon-s-plus class="-ml-1 mr-2 h-5 w-5" />
                        Nouveau sujet
                    </x-button>
                @endif
            </div>
        </div>
    @endif
</div>
