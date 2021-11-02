<li>
    <div class="relative pb-8">
        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex items-start space-x-3">
            <div>
                <div class="relative px-1">
                    <div class="h-8 w-8 bg-skin-card rounded-full ring-8 ring-card flex items-center justify-center">
                        <x-heroicon-s-user-add class="h-6 w-6 text-skin-base" />
                    </div>
                </div>
            </div>
            <div class="min-w-0 flex-1 py-1.5">
                <div class="text-sm text-skin-base">
                    <a href="{{ route('profile', ['username' => $user->username]) }}" class="font-medium text-skin-inverted font-sans">{{ $user->name }}</a>
                    a commencé a suivre
                    <a href="#" class="font-medium text-skin-inverted font-sans">Fabrice Yopa</a>
                    <span class="whitespace-nowrap font-sans">il y'a 3h</span>
                </div>
            </div>
        </div>
    </div>
</li>
