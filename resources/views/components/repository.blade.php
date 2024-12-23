@props([
    'repository',
])

<li class="group relative flex flex-col items-start isolate">
    <div class="relative z-10 flex size-12 items-center justify-center rounded-full bg-white shadow-md shadow-gray-800/5 ring-1 ring-gray-900/5 dark:border dark:border-white/10 dark:bg-gray-800 dark:ring-0">
        <x-icon.github class="size-8" aria-hidden="true" />
    </div>
    <h2 class="mt-6 text-base font-semibold text-gray-800 dark:text-gray-100">
        <div class="absolute -inset-x-4 -inset-y-6 z-0 scale-95 bg-white opacity-0 transition group-hover:scale-100 group-hover:opacity-100 sm:-inset-x-6 rounded-2xl dark:bg-gray-800"
        ></div>
        <a href="{{ $repository->html_url }}" target="_blank">
            <span class="absolute -inset-x-4 -inset-y-6 z-20 sm:-inset-x-6 rounded-2xl"></span>
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
    <p class="relative z-10 mt-2 text-sm text-gray-600 dark:text-gray-400">
        {{ $repository->description }}
    </p>
    <p class="relative z-10 mt-6 flex text-sm text-gray-400 transition group-hover:text-primary-500 dark:text-gray-200">
        <svg viewBox="0 0 24 24" aria-hidden="true" class="size-6 flex-none">
            <path
                d="M15.712 11.823a.75.75 0 1 0 1.06 1.06l-1.06-1.06Zm-4.95 1.768a.75.75 0 0 0 1.06-1.06l-1.06 1.06Zm-2.475-1.414a.75.75 0 1 0-1.06-1.06l1.06 1.06Zm4.95-1.768a.75.75 0 1 0-1.06 1.06l1.06-1.06Zm3.359.53-.884.884 1.06 1.06.885-.883-1.061-1.06Zm-4.95-2.12 1.414-1.415L12 6.344l-1.415 1.413 1.061 1.061Zm0 3.535a2.5 2.5 0 0 1 0-3.536l-1.06-1.06a4 4 0 0 0 0 5.656l1.06-1.06Zm4.95-4.95a2.5 2.5 0 0 1 0 3.535L17.656 12a4 4 0 0 0 0-5.657l-1.06 1.06Zm1.06-1.06a4 4 0 0 0-5.656 0l1.06 1.06a2.5 2.5 0 0 1 3.536 0l1.06-1.06Zm-7.07 7.07.176.177 1.06-1.06-.176-.177-1.06 1.06Zm-3.183-.353.884-.884-1.06-1.06-.884.883 1.06 1.06Zm4.95 2.121-1.414 1.414 1.06 1.06 1.415-1.413-1.06-1.061Zm0-3.536a2.5 2.5 0 0 1 0 3.536l1.06 1.06a4 4 0 0 0 0-5.656l-1.06 1.06Zm-4.95 4.95a2.5 2.5 0 0 1 0-3.535L6.344 12a4 4 0 0 0 0 5.656l1.06-1.06Zm-1.06 1.06a4 4 0 0 0 5.657 0l-1.061-1.06a2.5 2.5 0 0 1-3.535 0l-1.061 1.06Zm7.07-7.07-.176-.177-1.06 1.06.176.178 1.06-1.061Z"
                fill="currentColor"
            />
        </svg>
        <span class="ml-2">github.com</span>
    </p>
</li>
