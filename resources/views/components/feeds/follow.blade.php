<li>
    <div class="relative pb-8">
        <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-skin-footer" aria-hidden="true"></span>
        <div class="relative flex items-start space-x-3">
            <div>
                <div class="relative px-1">
                    <div class="h-8 w-8 bg-skin-card rounded-full ring-8 ring-card flex items-center justify-center">
                        <svg class="h-6 w-6 text-skin-base" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="min-w-0 flex-1 py-1.5">
                <div class="text-sm text-skin-base">
                    <a href="{{ route('profile', ['username' => $user->username]) }}" class="font-medium text-skin-inverted font-sans">{{ $user->name }}</a>
                    a commencé a suivre
                    <a href="#" class="font-medium text-skin-inverted font-sans">Fabrice Yopa</a>
                    <span class="whitespace-nowrap font-sans">il y a 3h</span>
                </div>
            </div>
        </div>
    </div>
</li>
