<x-app-layout title="Vérification de l'adresse e-mail">
    <div class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <div>
            <img class="logo-white h-12 w-auto sm:h-16" src="{{ asset('/images/laravelcm.svg') }}" alt="Laravel.cm" />
            <img
                class="logo-dark h-12 w-auto sm:h-16"
                src="{{ asset('/images/laravelcm-white.svg') }}"
                alt="Laravel.cm"
            />
        </div>

        <div class="mt-6 w-full sm:max-w-md lg:mt-10 lg:max-w-xl">
            <div class="mb-4 text-center text-sm text-skin-base">
                Merci pour votre inscription ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en
                cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous n'avez pas reçu l'e-mail, nous
                nous ferons un plaisir de vous en envoyer un autre.
            </div>

            <div class="mt-8 overflow-hidden bg-skin-card px-6 py-4 shadow-md sm:rounded-lg">
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="shrink-0">
                                <x-heroicon-s-check-circle class="h-5 w-5 text-green-400" />
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez
                                    fournie lors de l'inscription ou la modification de votre adresse.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div>
                            <x-button type="submit">Renvoyer l'e-mail de vérification</x-button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="text-sm text-skin-base underline hover:text-skin-inverted focus:outline-none"
                        >
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
