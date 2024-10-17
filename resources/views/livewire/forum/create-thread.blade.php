<div>
    <div>
        @include('livewire.forum._form')
    </div>

    <div class="mt-10 rounded-xl bg-yellow-50 p-4 ring-1 ring-inset ring-yellow-200">
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-alert-triangle class="size-5 text-yellow-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    {{ __('pages/forum.info.title') }}
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>
                        {{ __('pages/forum.info.description') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
