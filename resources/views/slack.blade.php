<x-app-layout title="Rejoindre Slack">
    <div class="mx-auto max-w-xl py-14">
        <div class="space-y-6">
            <x-error-message />

            <x-status-message />

            <div class="text-center">
                <div class="flex items-center justify-center space-x-4">
                    <svg class="h-14 w-14" viewBox="-2.45 0 2452.5 2452.5" xmlns="http://www.w3.org/2000/svg">
                        <g clip-rule="evenodd" fill-rule="evenodd">
                            <path
                                d="m897.4 0c-135.3.1-244.8 109.9-244.7 245.2-.1 135.3 109.5 245.1 244.8 245.2h244.8v-245.1c.1-135.3-109.5-245.1-244.9-245.3.1 0 .1 0 0 0m0 654h-652.6c-135.3.1-244.9 109.9-244.8 245.2-.2 135.3 109.4 245.1 244.7 245.3h652.7c135.3-.1 244.9-109.9 244.8-245.2.1-135.4-109.5-245.2-244.8-245.3z"
                                fill="#36c5f0"
                            />
                            <path
                                d="m2447.6 899.2c.1-135.3-109.5-245.1-244.8-245.2-135.3.1-244.9 109.9-244.8 245.2v245.3h244.8c135.3-.1 244.9-109.9 244.8-245.3zm-652.7 0v-654c.1-135.2-109.4-245-244.7-245.2-135.3.1-244.9 109.9-244.8 245.2v654c-.2 135.3 109.4 245.1 244.7 245.3 135.3-.1 244.9-109.9 244.8-245.3z"
                                fill="#2eb67d"
                            />
                            <path
                                d="m1550.1 2452.5c135.3-.1 244.9-109.9 244.8-245.2.1-135.3-109.5-245.1-244.8-245.2h-244.8v245.2c-.1 135.2 109.5 245 244.8 245.2zm0-654.1h652.7c135.3-.1 244.9-109.9 244.8-245.2.2-135.3-109.4-245.1-244.7-245.3h-652.7c-135.3.1-244.9 109.9-244.8 245.2-.1 135.4 109.4 245.2 244.7 245.3z"
                                fill="#ecb22e"
                            />
                            <path
                                d="m0 1553.2c-.1 135.3 109.5 245.1 244.8 245.2 135.3-.1 244.9-109.9 244.8-245.2v-245.2h-244.8c-135.3.1-244.9 109.9-244.8 245.2zm652.7 0v654c-.2 135.3 109.4 245.1 244.7 245.3 135.3-.1 244.9-109.9 244.8-245.2v-653.9c.2-135.3-109.4-245.1-244.7-245.3-135.4 0-244.9 109.8-244.8 245.1 0 0 0 .1 0 0"
                                fill="#e01e5a"
                            />
                        </g>
                    </svg>
                    <x-untitledui-switch-horizontal class="size-6 text-gray-400" />
                    <x-brand.icon class="block h-10 w-auto sm:h-12" />
                </div>
                <h2 class="mt-4 font-heading text-xl font-medium text-gray-900">Rejoindre le groupe Slack</h2>
                <p class="mt-3 leading-6 text-gray-500 dark:text-gray-400">
                    Rejoignez notre slack pour discuter a propos de Laravel, Javascript, Design, comment démarrer et
                    mener un projet de bout en bout, et découvrez l'univers du développement au Cameroun.
                </p>
            </div>

            <form action="{{ route('slack.send') }}" method="POST" class="mt-6 flex">
                @csrf
                <label for="email" class="sr-only">Adresse email</label>
                <x-email
                    type="email"
                    name="email"
                    id="email"
                    container-class="w-full flex-1"
                    placeholder="Renseigner votre email"
                    required
                />
                <x-button type="submit" class="ml-4">Rejoindre</x-button>
            </form>
        </div>
    </div>

    <x-container class="max-w-6xl pb-12">
        <section class="mx-auto max-w-3xl text-center">
            <h2 class="mb-3 text-center font-heading text-2xl font-bold leading-7 tracking-tight text-gray-900">
                Les autres groupes
            </h2>
            <p class="mx-auto max-w-3xl text-center leading-6 text-gray-500 dark:text-gray-400">
                Que vous soyez un débutant ou un développeur expérimenté, vous impliquez dans la communauté Laravel
                Cameroun est un excellent moyen d'entrer en contact avec des personnes partageant les mêmes idées et qui
                construisent des choses géniales avec le framework.
            </p>
        </section>
        <ul class="mt-12 grid grid-cols-1 items-start gap-x-8 gap-y-10 xl:grid-cols-3">
            <li class="relative flex flex-col items-start sm:flex-row xl:flex-col">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 font-medium text-gray-900">
                        <span class="mb-1 block leading-6 text-[#28D146]">WhatsApp</span>
                        Groupe accessible à tous mais limité à moins de 500 personnes
                    </h3>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300/60">
                        Si vous êtes un habitué de WhatsApp, nous avons un groupe qui regroupe près de 350 développeurs
                        junior et senior qui pourront discuter et échanger avec vous.
                    </p>
                    <x-default-button :href="route('whatsapp')" target="_blank" class="mt-6 w-auto font-normal">
                        Rejoindre
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#28D146] to-[#5FFC7B]">
                    <img class="h-auto w-1/2" src="{{ asset('images/brands/whatsapp.svg') }}" alt="WhatsApp" />
                </x-social-group-card>
            </li>
            <li class="relative flex flex-col items-start sm:flex-row xl:flex-col">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 font-medium text-gray-900">
                        <span class="mb-1 block leading-6 text-[#27A7E7]">Telegram</span>
                        La plus grosse communauté de Laravel Cameroun
                    </h3>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300/60">
                        Avec le plus grand nombre de membres c'est la plateforme qui nous affectionne le plus alors
                        n'hésitez surtout pas à nous rejoindre.
                    </p>
                    <x-default-button :href="route('telegram')" target="_blank" class="mt-6 w-auto font-normal">
                        Rejoindre
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#27A7E7] to-[#0088cc]">
                    <div class="flex items-center">
                        <img class="h-auto w-14" src="{{ asset('images/brands/telegram.svg') }}" alt="Telegram" />
                        <p class="ml-2 text-3xl font-bold text-white">Telegram</p>
                    </div>
                </x-social-group-card>
            </li>
            <li class="relative flex flex-col items-start sm:flex-row xl:flex-col">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 font-medium text-gray-900">
                        <span class="mb-1 block leading-6 text-[#5865F2]">Discord</span>
                        Le tout dernier venu, mais notre plus grand coup de cœur
                    </h3>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300/60">
                        Discord est le dernier réseau rejoint par la communauté, vous pouvez nous rejoindre et
                        participer à toutes nos activités.
                    </p>
                    <x-default-button :href="route('discord')" target="_blank" class="mt-6 w-auto font-normal">
                        Rejoindre
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#5865F2] to-[#1928D5]">
                    <img class="h-auto w-1/2" src="{{ asset('images/brands/discord.svg') }}" alt="Discord" />
                </x-social-group-card>
            </li>
        </ul>
    </x-container>
</x-app-layout>
