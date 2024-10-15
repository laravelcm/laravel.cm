@if ($errors->any())
    <div class="mb-4 rounded-md bg-red-50 p-4">
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-x class="h-5 w-5 text-red-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Oups ! Nous avons rencontré des erreurs.</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
