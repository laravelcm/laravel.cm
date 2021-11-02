@props(['activity'])

@if($activity->subject->isPublished())
    <li>
        <div class="relative pb-8">
            <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
            <div class="relative flex items-start space-x-3">
                <div class="relative">
                    <img class="h-10 w-10 rounded-full bg-skin-card flex items-center justify-center ring-8 ring-card" src="{{ $activity->user->profile_photo_url }}" alt="Avatar de {{ $activity->user->username }}">
                    <span class="absolute -bottom-0.5 -right-1 bg-skin-card rounded-tl px-0.5 py-px">
                        <x-heroicon-s-chat-alt class="h-5 w-5 text-skin-muted" />
                    </span>
                </div>
                <div class="min-w-0 flex-1">
                    <div>
                        <div class="text-sm">
                            <a href="{{ route('profile', ['username' => $activity->user->username]) }}" class="font-medium text-skin-inverted font-sans">{{ $activity->user->name }}</a>
                        </div>
                        <p class="mt-0.5 text-sm text-skin-base font-sans">
                            a commenté il y'a 10min
                        </p>
                    </div>
                    <div class="mt-2 text-sm text-skin-inverted-muted font-normal">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
