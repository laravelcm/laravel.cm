<?php

declare(strict_types=1);

use function Livewire\Volt\{state};

state([
    'profiles' => [
        [
            'name' => 'Arthur Monney',
            'title' => 'Dévelopeur Advocate & Fullstack',
            'avatar' => 'https://avatars.githubusercontent.com/u/14105989?v=4',
            'social_links' => [
                'twitter' => 'https://twitter.com/MonneyArthur',
                'github' => 'https://github.com/mckenziearts',
                'linkedin' => 'https://www.linkedin.com/in/arthurmonney',
            ],
        ],
        [
            'name' => 'Fabrice Yopa',
            'title' => 'Co-Founder & CTO IS Dev Experts',
            'avatar' => 'https://avatars.githubusercontent.com/u/4902424?v=4',
            'social_links' => [
                'twitter' => 'https://twitter.com/yopafabrice',
                'github' => 'https://github.com/fabriceyopa',
                'linkedin' => 'https://www.linkedin.com/in/fabriceyopa',
            ],
        ],
        [
            'name' => 'Chris Samory',
            'title' => ' Web Fullstack Developer',
            'avatar' => 'https://avatars.githubusercontent.com/u/62399387?s=96&v=4',
            'social_links' => [
                'twitter' => 'https://x.com/NdeTakougne',
                'github' => 'https://github.com/cybersoldattech',
                'linkedin' => 'https://www.linkedin.com/in/chris-samory-takougne-nde-003084224/',
            ],
        ],
        [
            'name' => 'Stevy Endaman',
            'title' => ' Web Fullstack Developer',
            'avatar' => 'https://avatars.githubusercontent.com/u/25743606?u=3e52c493f01b83c582b8e2fc845efc83f1c4d83d',
            'social_links' => [
                'twitter' => 'https://x.com/stevyabessolo',
                'github' => 'https://github.com/StevyMarlino',
                'linkedin' => 'https://www.linkedin.com/in/endaman-stevy',
            ],
        ]
    ]

]);

?>

<div>
    <x-container>
        <header class="py-8 sm:py-10 lg:grid lg:grid-cols-2 lg:gap-x-12 lg:py-12">
            <div class="sm:text-center md:mx-auto md:max-w-2xl lg:mx-0 lg:text-left">
                <h1 class="text-gray-900">
                    <span class="block text-sm font-semibold text-primary-600 sm:text-base lg:text-sm xl:text-base">
                        {{ __('pages/about.title') }}
                    </span>
                    <span
                        class="mt-2 block text-2xl font-extrabold tracking-tight sm:text-3xl xl:text-4xl xl:leading-[3rem]"
                    >
                        {{ __('pages/about.description') }}
                    </span>
                </h1>
            </div>
            <div class="mt-8 sm:text-center lg:text-left">
                <p class="text-base font-normal leading-6 text-gray-500 dark:text-gray-400 sm:text-lg">
                    <span class="font-medium text-gray-900">
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
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900"> {{ __('pages/about.stats.member_discord') }} </dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+300</dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900"> {{ __('pages/about.stats.member_telegram') }} </dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+700</dd>
                </div>
                <div class="flex flex-col p-6 text-center sm:p-10">
                    <dt class="order-2 mt-2 text-lg font-medium leading-6 text-green-900"> {{ __('pages/about.stats.member_whatsapp') }} </dt>
                    <dd class="order-1 font-heading text-5xl font-extrabold text-green-600">+350</dd>
                </div>
            </dl>
        </section>

        <div class="mx-auto max-w-3xl py-8 sm:py-10 lg:max-w-none lg:py-12 xl:pb-20">
            <h1 class="font-sans text-gray-900">
                <span class="block text-sm font-semibold text-primary-600 sm:text-base lg:text-sm xl:text-base">
                    {{ __('pages/about.history') }}
                </span>
                <span class="mt-1 block font-heading text-xl font-extrabold tracking-tight sm:text-2xl xl:text-3xl">
                      {{ __('pages/about.history_part_one') }}
                </span>
            </h1>

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
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778123/IMG_1637_yjaqrk.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1505_j06cwz.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[1/2]"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1609_otohw5.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[2/5]"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778121/IMG_1605_zdgdpv.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[4/5]"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703778122/IMG_1567_hfy747.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg"
                            />
                            <div
                                class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-gray-900/10"
                            ></div>
                        </div>
                        <div class="relative">
                            <img
                                src="https://res.cloudinary.com/dlzdb3m6n/image/upload/v1703782759/phnnfnzxt8khtrth4qem.jpg"
                                alt=""
                                class="aspect-[2/3] w-full rounded-xl bg-gray-900/5 object-cover shadow-lg lg:aspect-[3/7]"
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
                    <div class="font-sans">
                        <h2
                            class="mt-2 font-heading text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl"
                        >
                            {{ __('pages/about.our_team.title') }}
                        </h2>
                        <p class="mt-5 text-lg text-gray-500 dark:text-gray-400">
                            {{ __('pages/about.our_team.description') }}
                        </p>
                    </div>
                    <div class="lg:col-span-2">
                        <ul
                            role="list"
                            class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8"
                        >
                            @foreach($profiles as $profile)
                                <li>
                                    <div class="space-y-4">
                                        <img class="h-16 w-16 rounded-full lg:h-20 lg:w-20" src="{{ $profile['avatar'] }}" alt="{{ $profile['name'] }}" />
                                        <div class="space-y-1 text-lg font-medium leading-6 text-gray-900">
                                            <h3>{{ $profile['name'] }}</h3>
                                            <p class="font-sans text-base text-green-600">{{ $profile['title'] }}</p>
                                        </div>

                                        <ul role="list" class="flex space-x-4">
                                            @foreach($profile['social_links'] as $platform => $url)
                                                <li>
                                                    <a href="{{ $url }}" target="_blank" class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400">
                                                        <span class="sr-only">{{ ucfirst($platform) }}</span>
                                                        <x-dynamic-component :component="'icon.'.$platform" class="size-6" aria-hidden="true" />
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
</div>
