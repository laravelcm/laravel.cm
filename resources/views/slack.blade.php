@title(__('Rejoindre Slack'))

@extends('layouts.default')

@section('body')

    <div class="max-w-xl mx-auto py-14">
        <div class="space-y-6">
            <x-error-message />

            <x-status-message />

            <div class="text-center">
                <div class="flex items-center justify-center space-x-4">
                    <svg class="h-14 w-14" viewBox="-2.45 0 2452.5 2452.5" xmlns="http://www.w3.org/2000/svg">
                        <g clip-rule="evenodd" fill-rule="evenodd">
                            <path d="m897.4 0c-135.3.1-244.8 109.9-244.7 245.2-.1 135.3 109.5 245.1 244.8 245.2h244.8v-245.1c.1-135.3-109.5-245.1-244.9-245.3.1 0 .1 0 0 0m0 654h-652.6c-135.3.1-244.9 109.9-244.8 245.2-.2 135.3 109.4 245.1 244.7 245.3h652.7c135.3-.1 244.9-109.9 244.8-245.2.1-135.4-109.5-245.2-244.8-245.3z" fill="#36c5f0"/><path d="m2447.6 899.2c.1-135.3-109.5-245.1-244.8-245.2-135.3.1-244.9 109.9-244.8 245.2v245.3h244.8c135.3-.1 244.9-109.9 244.8-245.3zm-652.7 0v-654c.1-135.2-109.4-245-244.7-245.2-135.3.1-244.9 109.9-244.8 245.2v654c-.2 135.3 109.4 245.1 244.7 245.3 135.3-.1 244.9-109.9 244.8-245.3z" fill="#2eb67d"/><path d="m1550.1 2452.5c135.3-.1 244.9-109.9 244.8-245.2.1-135.3-109.5-245.1-244.8-245.2h-244.8v245.2c-.1 135.2 109.5 245 244.8 245.2zm0-654.1h652.7c135.3-.1 244.9-109.9 244.8-245.2.2-135.3-109.4-245.1-244.7-245.3h-652.7c-135.3.1-244.9 109.9-244.8 245.2-.1 135.4 109.4 245.2 244.7 245.3z" fill="#ecb22e"/><path d="m0 1553.2c-.1 135.3 109.5 245.1 244.8 245.2 135.3-.1 244.9-109.9 244.8-245.2v-245.2h-244.8c-135.3.1-244.9 109.9-244.8 245.2zm652.7 0v654c-.2 135.3 109.4 245.1 244.7 245.3 135.3-.1 244.9-109.9 244.8-245.2v-653.9c.2-135.3-109.4-245.1-244.7-245.3-135.4 0-244.9 109.8-244.8 245.1 0 0 0 .1 0 0" fill="#e01e5a"/>
                        </g>
                    </svg>
                    <x-heroicon-o-switch-horizontal class="h-6 w-6 text-gray-400" />
                    <x-application-icon class="block h-10 w-auto sm:h-12" />
                </div>
                <h2 class="mt-4 text-xl font-medium font-heading text-skin-inverted">{{ __('Rejoindre le groupe Slack') }}</h2>
                <p class="mt-3 leading-6 text-skin-base">
                    {{ __('Rejoignez notre slack pour discuter a propos de Laravel, Javascript, Design, comment démarrer et mener un projet de bout en bout, et découvrez l\'univers du développement au Cameroun.') }}
                </p>
            </div>

            <form action="{{ route('slack.send') }}" method="POST" class="mt-6 flex">
                @csrf
                <label for="email" class="sr-only">{{ __('Adresse email') }}</label>
                <x-email type="email" name="email" id="email" container-class="w-full flex-1" placeholder="Renseigner votre email" required />
                <x-button type="submit" class="ml-4">
                    {{ __('Rejoindre') }}
                </x-button>
            </form>
        </div>
    </div>

    <x-container class="px-4 mx-auto max-w-6xl pb-12">
        <section class="text-center max-w-3xl mx-auto">
            <h2 class="mb-3 text-2xl leading-7 font-heading text-center tracking-tight text-skin-inverted font-bold">{{ __('Les autres groupes') }}</h2>
            <p class="leading-6 text-skin-base mx-auto max-w-3xl text-center">
                {{ __('Que vous soyez un débutant ou un développeur expérimenté, vous impliquer dans la communauté Laravel Cameroun est un excellent moyen d\'entrer en contact avec des personnes partageant les mêmes idées et qui construisent des choses géniales avec le framework.') }}
            </p>
        </section>
        <ul class="mt-12 grid grid-cols-1 xl:grid-cols-3 gap-y-10 gap-x-8 items-start">
            <li class="relative flex flex-col sm:flex-row xl:flex-col items-start">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 text-skin-inverted font-medium">
                        <span class="mb-1 block leading-6 text-[#28D146]">WhatsApp</span>
                        {{ __('Groupe accessible á tous mais limité à moins de 300 personnes') }}
                    </h3>
                    <p class="text-sm leading-5 text-skin-inverted-muted/60">
                        {{ __('Si vous êtes un habitué de WhatsApp, nous avons un groupe qui regroupe près de 250 développeurs junior et senior qui pourront discuter et échanger avec vous.') }}
                    </p>
                    <x-default-button :link="route('whatsapp')" target="_blank" class="w-auto font-normal mt-6">
                        {{ __('Rejoindre') }}
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#28D146] to-[#5FFC7B]">
                    <img class="w-1/2 h-auto" src="{{ asset('images/brands/whatsapp.svg') }}" alt="WhatsApp">
                </x-social-group-card>
            </li>
            <li class="relative flex flex-col sm:flex-row xl:flex-col items-start">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 text-skin-inverted font-medium">
                        <span class="mb-1 block leading-6 text-[#27A7E7]">Telegram</span>
                        {{ __('La plus grosse communauté de Laravel Cameroun') }}
                    </h3>
                    <p class="text-sm leading-5 text-skin-inverted-muted/60">
                        {{ __('Avec le plus grand nombre de membres c\'est la plateforme qui nous affectionne le plus alors n\'hésitez surtout pas à nous rejoindre.') }}
                    </p>
                    <x-default-button :link="route('telegram')" target="_blank" class="w-auto font-normal mt-6">
                        {{ __('Rejoindre') }}
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#27A7E7] to-[#0088cc]">
                    <div class="flex items-center">
                        <img class="w-14 h-auto" src="{{ asset('images/brands/telegram.svg') }}" alt="Telegram">
                        <p class="ml-2 text-white font-bold text-3xl">Telegram</p>
                    </div>
                </x-social-group-card>
            </li>
            <li class="relative flex flex-col sm:flex-row xl:flex-col items-start">
                <div class="order-1 sm:ml-6 xl:ml-0">
                    <h3 class="mb-1 text-skin-inverted font-medium">
                        <span class="mb-1 block leading-6 text-[#5865F2]">Discord</span>
                        {{ __('Le tout dernier venu mais notre plus grand coup de coeur') }}
                    </h3>
                    <p class="text-sm leading-5 text-skin-inverted-muted/60">
                        {{ __('Discord est le dernier réseau rejoins par la communauté, vous pouvez nous rejoindre et participer à tous nos activités.') }}
                    </p>
                    <x-default-button :link="route('discord')" target="_blank" class="w-auto font-normal mt-6">
                        {{ __('Rejoindre') }}
                    </x-default-button>
                </div>
                <x-social-group-card class="from-[#5865F2] to-[#1928D5]">
                    <img class="w-1/2 h-auto" src="{{ asset('images/brands/discord.svg') }}" alt="Discord">
                </x-social-group-card>
            </li>
        </ul>
    </x-container>


@endsection
