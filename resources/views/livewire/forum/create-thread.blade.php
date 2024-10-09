<div>
    @include('livewire.forum._form')

    <div class="mt-10 rounded-xl bg-yellow-50 p-4 ring-1 ring-inset ring-yellow-200">
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-alert-triangle class="size-5 text-yellow-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Bon à savoir</h3>
                <div class="mt-2 font-sans text-sm text-yellow-700">
                    <p>
                        Veuillez rechercher votre question avant de publier votre sujet en utilisant le champ de
                        recherche dans la barre de navigation pour voir si elle n'a pas déjà été traitée.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
