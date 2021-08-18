@title('Tous les articles')

@extends('layouts.default')

@section('body')

    <div class="lg:grid lg:grid-cols-9 lg:gap-10">
        <div class="hidden lg:block lg:col-span-2">
            <div class="sticky top-4 divide-y divide-skin-base">
                <div class="pb-8 space-y-1">
                    <a href="#" class="bg-skin-link text-skin-inverted group flex items-center px-3 py-2 text-sm font-medium rounded-md font-sans">
                        <svg class="text-skin-base flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path d="M15.596 15.696h-7.22M15.596 11.937h-7.22M11.131 8.177H8.376" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path clip-rule="evenodd" d="M3.61 12c0 6.937 2.098 9.25 8.391 9.25 6.294 0 8.391-2.313 8.391-9.25 0-6.937-2.097-9.25-8.391-9.25C5.708 2.75 3.61 5.063 3.61 12z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="truncate">
                            Récents
                        </span>
                    </a>

                    <a href="#" class="text-skin-base group flex items-center px-3 py-2 text-sm font-medium rounded-md font-sans">
                        <svg class="text-skin-muted group-hover:text-skin-base flex-shrink-0 -ml-1 mr-3 h-6 w-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path clip-rule="evenodd" d="M12 3C9.964 3 9.771 6.547 8.56 7.8c-1.213 1.253-4.982-.18-5.505 2.044-.523 2.225 2.867 2.98 3.285 4.89.42 1.909-1.65 4.59.12 5.926 1.77 1.334 3.674-1.685 5.54-1.685s3.77 3.019 5.54 1.685c1.77-1.335-.3-4.017.12-5.927.419-1.909 3.808-2.664 3.285-4.889-.522-2.224-4.292-.791-5.503-2.044C14.23 6.547 14.036 3 12 3z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="truncate">
                            Populaire
                        </span>
                    </a>

                    <a href="#" class="text-skin-base group flex items-center px-3 py-2 text-sm font-medium rounded-md font-sans">
                        <svg class="text-skin-muted group-hover:text-skin-base flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path d="M6.98 4.601V17.22M2.9 8.7s2.169-4.1 4.078-4.1c1.908 0 4.078 4.1 4.078 4.1M16.906 19.428V6.81M20.985 15.329s-2.17 4.1-4.078 4.1c-1.908 0-4.078-4.1-4.078-4.1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="truncate">
                            Tendance
                        </span>
                    </a>

                </div>

                <div class="pt-8">
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-skin-link text-skin-base font-sans">
                        <svg class="mr-1.5 h-2 w-2 text-skin-base" fill="currentColor" viewBox="0 0 8 8">
                            <circle cx="4" cy="4" r="3" />
                        </svg>
                        Tous les tags
                    </span>

                    <div class="mt-4" aria-labelledby="posts-tags">

                        <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                            <span class="text-skin-muted group-hover:hidden">#</span>
                            <svg class="mr-1.5 h-2 w-2 brand-open-source hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span class="truncate">opensource</span>
                        </button>

                        <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                            <span class="text-skin-muted group-hover:hidden">#</span>
                            <svg class="mr-1.5 h-2 w-2 brand-alpinejs hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span class="truncate">alpinejs</span>
                        </button>

                        <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                            <span class="text-skin-muted group-hover:hidden">#</span>
                            <svg class="mr-1.5 h-2 w-2 brand-laravel hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span class="truncate">laravel</span>
                        </button>

                        <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                            <span class="text-skin-muted group-hover:hidden">#</span>
                            <svg class="mr-1.5 h-2 w-2 brand-packages hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span class="truncate">packages</span>
                        </button>

                        <button type="button" class="mb-1.5 group inline-flex items-center px-3 py-1 text-sm font-medium text-skin-inverted rounded-full border border-skin-input font-sans">
                            <span class="text-skin-muted group-hover:hidden">#</span>
                            <svg class="mr-1.5 h-2 w-2 brand-design hidden group-hover:block" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            <span class="truncate">design</span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
        <div class="lg:grid lg:grid-cols-8 lg:gap-8 lg:col-span-7">
            <div class="lg:col-span-6">
                <div class="pb-5 border-b border-skin-input">
                    <h1 class="text-3xl leading-8 font-extrabold text-skin-inverted font-sans">
                        Récentes publications
                    </h1>
                    <p class="mt-2 max-w-4xl text-sm text-skin-base leading-5 font-sans">Tous les articles récemment publiés.</p>
                </div>

                <div class="py-12 space-y-8 sm:space-y-10 max-w-lg mx-auto lg:max-w-none">
                    <x-articles.overview />

                    <x-articles.overview />

                    <x-articles.overview />

                    <x-articles.overview />
                </div>
            </div>

            <div class="hidden lg:block lg:col-span-2">
                <div class="sticky top-4">
                    <div class="text-right">
                        <h4 class="text-skin-inverted text-sm leading-5 font-semibold uppercase tracking-wide font-sans">Sponsors</h4>
                        <div class="mt-5 space-y-4">
                            <a href="https://lotin-corp.biz" class="flex items-center justify-end">
                                <img class="w-auto h-12" src="{{ asset('images/sponsors/lotin-corp.svg') }}" alt="Lotin Corp">
                            </a>
                            <a href="https://gdg.community.dev/gdg-douala" class="flex items-center justify-end">
                                <img class="w-auto h-4" src="{{ asset('images/sponsors/gdg-douala.svg') }}" alt="GDG Douala">
                            </a>
                        </div>
                    </div>

                    <x-ads />
                </div>
            </div>
        </div>
    </div>

@endsection
