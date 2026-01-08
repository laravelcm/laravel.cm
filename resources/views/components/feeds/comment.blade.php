<div class="relative pb-8">
    <div class="relative flex items-start space-x-3">
        <div class="relative">
            <x-user.avatar :$user />
            <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white dark:bg-gray-800 px-0.5 py-px">
                <svg
                    class="size-5 text-gray-400 dark:text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"
                    />
                </svg>
            </span>
        </div>
        <div class="min-w-0 flex-1">
            <div>
                <div class="text-sm">
                    <x-link
                        :href="route('profile', ['username' => $user->username])"
                        class="font-sans font-medium text-gray-900 dark:text-white"
                    >
                        {{ $user->name }}
                    </x-link>
                </div>
                <p class="mt-0.5 font-sans text-sm text-gray-500 dark:text-gray-400">a commenté il y a 2 jours</p>
            </div>
            <div class="mt-2 text-sm font-normal text-gray-700 dark:text-gray-300">
                <p>...</p>
            </div>
        </div>
    </div>
</div>
