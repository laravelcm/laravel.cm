@props([
    'repository',
])

<li class="group p-6 relative flex flex-col items-start isolate">
    <div class="relative z-10 flex size-12 items-center justify-center rounded-full bg-white shadow-md shadow-gray-800/5 ring-1 ring-gray-900/5 dark:border dark:border-white/10 dark:bg-gray-800 dark:ring-0">
        <x-icon.github class="size-8" aria-hidden="true" />
    </div>
    <h2 class="mt-6 text-base font-semibold text-gray-900 dark:text-white">
        <a href="{{ $repository->html_url }}" target="_blank">
            <span class="absolute inset-0"></span>
            <span class="relative inline-flex items-center gap-2 z-10">
                {{ $repository->name }}
                <span class="inline-flex items-center pointer-events-none rounded-full bg-gray-50 p-1.5 text-gray-500 dark:bg-white/10 dark:text-gray-300">
                    <svg
                        class="size-3 transition duration-300 ease-in-out group-hover:rotate-45"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z"
                        />
                    </svg>
                </span>
            </span>
        </a>
    </h2>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
        {{ $repository->description }}
    </p>
    <p class="mt-6 flex text-sm text-gray-400 transition group-hover:text-primary-500 dark:text-gray-200">
        <x-untitledui-link class="size-5" aria-hidden="true" />
        <span class="ml-2">github.com</span>
    </p>
</li>
