<x-app-layout :title="__('pages/about.title')">
    <x-container>
        <header class="py-8 sm:py-10 lg:grid lg:grid-cols-2 lg:gap-x-12 lg:py-12">
            <div class="sm:text-center md:mx-auto md:max-w-2xl lg:mx-0 lg:text-left">
                <p class="text-sm font-medium text-primary-600 sm:text-base lg:text-lg">
                    {{ __('pages/about.title') }}
                </p>
                <h1 class="text-gray-900 mt-2 text-2xl font-extrabold font-heading tracking-tight sm:text-3xl xl:text-4xl xl:leading-[3rem]">
                    {{ __('pages/about.description') }}
                </h1>
            </div>
            <div class="mt-8 sm:text-center lg:text-left">
                <p class="text-base leading-6 text-gray-500 dark:text-gray-400 sm:text-lg">
                    <span class="font-medium font-mono text-gray-900">
                        <span class="italic text-primary-600">"</span>
                        {{ __('pages/about.second_description_part_one') }}
                        <span class="italic text-primary-600">"</span>
                    </span>
                    {{ __('pages/about.second_description_part_two') }}
                </p>
            </div>
        </header>

        <section class="my-10" aria-describedby="stats section">
            <dl class="rounded-xl bg-green-50 ring-1 ring-green-200 sm:grid sm:grid-cols-3">
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900">{{ __('pages/about.stats.member_discord') }}</dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+300</dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900">{{ __('pages/about.stats.member_telegram') }}</dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+700</dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900">{{ __('pages/about.stats.member_whatsapp') }}</dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+350</dd>
                </div>
            </dl>
        </section>

        <div class="mx-auto max-w-3xl py-8 sm:py-10 lg:max-w-none lg:py-12 xl:pb-20">
            <p class="text-sm font-medium text-primary-600 sm:text-base">
                {{ __('pages/about.history') }}
            </p>
            <h2 class="mt-1 font-heading text-gray-900 text-2xl font-bold tracking-tight sm:text-3xl">
                {{ __('pages/about.history_part_one') }}
            </h2>

            <div class="prose prose-lg prose-green mt-5 text-gray-500 dark:text-gray-400 lg:max-w-none">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
                    <div>
                        <p>
                            {{ __('pages/about.first_description') }}
                        </p>
                        <p>
                            {{ __('pages/about.second_description') }}
                        </p>
                        <ul class="font-normal">
                            <li>
                                {{ __('pages/about.list.one.title') }}
                                <a href="https://activspaces.com?utm_source=laravel.cm">ActivSpaces</a>
                                {{ __('pages/about.list.one.description') }}
                            </li>
                            <li>
                                {{ __('pages/about.list.two.title') }}
                                <span class="font-medium text-primary-600">Kerawa Cameroun</span>
                                {{ __('pages/about.list.two.description') }}
                            </li>
                            <li>
                                {{ __('pages/about.list.three.title') }}
                                <span class="font-medium text-primary-600">John's Corporation</span>
                                {{ __('pages/about.list.three.description') }}
                            </li>
                            <li>
                                {{ __('pages/about.list.four.title') }}
                                <a href="https://twitter.com/DarkCodeCompany?utm_source=laravel.cm" target="_blank">Dark Code</a>
                                {{ __('pages/about.list.four.description') }}
                            </li>
                            <li>
                                {{ __('pages/about.list.five.title') }}
                                <a href="https://diool.com?utm_source=laravel.cm" target="_blank">Diool</a>
                                {{ __('pages/about.list.five.description') }}
                            </li>
                        </ul>
                        <p>
                            {{ __('pages/about.list.paragraph_one') }}
                        </p>
                    </div>
                    <div class="mt-14 columns-2 gap-4 sm:columns-3 lg:mt-0">
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778123/IMG_1637_yjaqrk.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1505_j06cwz.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-1/2"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1609_otohw5.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-2/5"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1605_zdgdpv.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-4/5"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1567_hfy747.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                loading="lazy"
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703782759/phnnfnzxt8khtrth4qem.jpg"
                                alt=""
                                class="aspect-2/3 w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-3/7"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 border-t border-skin-base pt-12 sm:mt-14 sm:pt-14">
                <div class="space-y-12 lg:grid lg:grid-cols-3 lg:gap-24 lg:space-y-0">
                    <div>
                        <h2 class="font-heading text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            {{ __('pages/about.our_team.title') }}
                        </h2>
                        <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                            {{ __('pages/about.our_team.description') }}
                        </p>
                    </div>
                    <div class="lg:col-span-2">
                        <ul
                            role="list"
                            class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8"
                        >
                            @foreach (config('lcm.members') as $profile)
                                <li>
                                    <div class="space-y-4">
                                        <img loading="lazy" class="size-16 rounded-full lg:size-20" src="{{ $profile['avatar'] }}" alt="{{ $profile['name'] }}" />
                                        <div class="space-y-1">
                                            <h3 class="font-heading text-lg font-semibold text-gray-900">{{ $profile['name'] }}</h3>
                                            <p class="text-base text-green-600">{{ $profile['title'] }}</p>
                                        </div>

                                        <ul role="list" class="flex space-x-4">
                                            @foreach ($profile['social_links'] as $platform => $url)
                                                <li>
                                                    <a href="{{ $url }}" target="_blank" class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400">
                                                        <span class="sr-only">{{ ucfirst($platform) }}</span>
                                                        <x-dynamic-component :component="'icon.'.$platform" class="size-5" aria-hidden="true" />
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                         </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
