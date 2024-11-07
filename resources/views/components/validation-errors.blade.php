@if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-50 p-4 dark:bg-red-800/20">
        <div class="flex">
            <div class="shrink-0">
                <x-untitledui-x class="size-5 text-red-400" aria-hidden="true" />
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800 dark:text-red-400">
                   {{ __('notifications.error') }}
                </h3>
                <div class="mt-2 text-sm text-red-700 dark:text-red-500">
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
