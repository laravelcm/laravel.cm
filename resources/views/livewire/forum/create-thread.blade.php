<div>
    @include('livewire.forum._form')

    <div class="mt-10 rounded-md bg-yellow-50 p-4">
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-alert-triangle class="h-5 w-5 text-yellow-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    {{ __('Bon à savoir') }}
                </h3>
                <div class="mt-2 text-sm text-yellow-700 font-sans">
                    <p>
                        {{ __('Veuillez rechercher votre question avant de publier votre sujet en utilisant le champ de recherche dans la barre de navigation pour voir si elle n\'a pas déjà été traitée.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
