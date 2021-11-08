@props(['author'])

<div class="bg-skin-card rounded-lg shadow">
    <div class="w-full flex items-center justify-between pt-4 px-4 space-x-3">
        <img class="w-8 h-8 bg-skin-card-gray rounded-full flex-shrink-0" src="{{ $author->profile_photo_url }}" alt="">
        <div class="flex-1 truncate">
            <div class="flex items-center space-x-3">
                <a href="{{ route('profile', $author->username) }}" class="text-skin-inverted text-sm font-medium truncate">{{ $author->name }}</a>
                @if($author->hasAnyRole('admin', 'moderator'))
                    <span class="flex-shrink-0 inline-block px-2 py-0.5 text-green-800 text-xs font-medium bg-green-100 rounded-full">Admin</span>
                @endif
            </div>
            <p class="text-skin-base text-sm truncate font-normal">{{ '@'. $author->username }}</p>
        </div>
    </div>
    <div class="space-y-4 p-4">
        @if($author->bio)
            <p class="text-skin-inverted-muted text-sm leading-5 font-normal">{{ $author->bio }}</p>
        @endif
        @if($author->location)
            <div>
                <dt class="text-[12px] font-medium text-skin-inverted-muted font-sans uppercase tracking-wider">
                    Localisation
                </dt>
                <dd class="text-skin-base font-normal">
                    {{ $author->location }}
                </dd>
            </div>
        @endif
        <div>
            <dt class="text-[12px] font-medium text-skin-inverted-muted font-sans uppercase tracking-wider">
                Inscrit Depuis
            </dt>
            <dd class="text-skin-base font-normal">
                {{ $author->created_at->toFormattedDateString() }}
            </dd>
        </div>
    </div>
</div>
