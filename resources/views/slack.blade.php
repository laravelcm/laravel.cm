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
                <h2 class="mt-4 text-xl font-medium font-heading text-skin-inverted">Rejoindre le groupe Slack</h2>
                <p class="mt-3 text-sm text-skin-base font-normal">
                    Rejoignez notre slack pour discuter a propos de Laravel, Javascript, Design, comment démarrer et mener un projet de bout en bout, et découvrez l'univers du développement au Cameroun.
                </p>
            </div>

            <form action="{{ route('slack.send') }}" method="POST" class="mt-6 flex">
                @csrf
                <label for="email" class="sr-only">{{ __('Adresse email') }}</label>
                <x-email type="email" name="email" id="email" container-class="w-full flex-1" placeholder="Renseigner votre email" required />
                <x-button type="submit" class="ml-4">
                    Rejoindre
                </x-button>
            </form>
        </div>
    </div>


@endsection
