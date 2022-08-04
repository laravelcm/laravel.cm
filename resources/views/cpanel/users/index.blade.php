<x-layouts.cp title="Tableau de bord">
    <x-container class="max-w-7xl mx-auto px-4 sm:px-6">
        <div>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-skin-inverted font-heading">{{ __('Utilisateurs') }}</h1>
                    <p class="mt-2 text-sm text-skin-inverted-muted">{{ __('Une liste de tous les utilisateurs de votre compte, avec leur nom, leur titre, leur email et leur rôle.') }}</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <x-button type="button">{{ __('Inviter') }}</x-button>
                </div>
            </div>
            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-skin-base">
                                <thead class="bg-skin-card-muted">
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-skin-inverted sm:pl-6">{{ __('Nom') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-skin-inverted">{{ __('Email') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-skin-inverted">{{ __('Role') }}</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-skin-inverted">{{ __('Inscription') }}</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">{{ __('Éditer') }}</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-skin-input bg-skin-menu">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-skin-inverted sm:pl-6">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="flex items-center font-medium text-skin-inverted">
                                                            {{ $user->name }}
                                                            @if($user->isLoggedInUser())
                                                                <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium leading-none bg-green-50 text-green-800">
                                                                    {{ __('Moi') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="text-skin-base">{{ $user->username }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-skin-base">{{ $user->email }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-skin-base">{{ $user->roles_label }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-skin-base">{{ $user->created_at->diffForHumans() }}</td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                @if(! $user->isLoggedInUser())
                                                    <a href="#" class="text-green-600 hover:text-green-900">{{ __('Afficher') }}<span class="sr-only">, {{ $user->name }}</span></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>

    </x-container>
</x-layouts.cp>
