<div x-data="{ open: false }" class="mt-10 flex items-center justify-center lg:mt-16">
    <div class="w-full max-w-3xl mx-auto">
        <button type="button" class="relative bg-white rounded-xl px-6 py-5 ring-1 ring-gray-200/60 flex items-center w-full gap-5 hover:ring-gray-300 dark:ring-white/20 dark:hover:ring-white/10 dark:bg-gray-800 dark:hover:bg-white/10 focus:outline transition duration-200 ease-in-out">
            <x-user.avatar
                :user="\Illuminate\Support\Facades\Auth::user()"
                class="size-10 ring-4 ring-white dark:ring-white/20"
                span="-right-1 size-3.5 -top-1"
            />
            <span class="text-sm leading-6 text-gray-500 dark:text-gray-300">
                {{ __('Laissez votre réponse') }}
            </span>
        </button>
        <div class="mt-5 text-center">
            <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">
                Assurez-vous d'avoir lu nos
                <x-link :href="route('rules')" class="font-medium text-primary-600 hover:text-primary-500">
                    règles de conduite
                </x-link>
                avant de répondre à ce thread.
            </p>
        </div>
    </div>

    <div></div>
</div>
