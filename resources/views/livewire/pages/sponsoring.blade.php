<div class="overflow-hidden section-gradient isolate">
    <x-container class="px-0">
        <div class="py-24 lg:line-x lg:py-32">
            <div class="px-4 mx-auto space-y-10 max-w-4xl">
                <div>
                    <h1 class="font-heading text-2xl font-bold text-gray-900 dark:text-white lg:text-4xl">
                        {{ __('pages/sponsoring.title') }}
                    </h1>
                    <div class="mt-10 prose prose-emerald overflow-x-hidden dark:prose-invert lg:max-w-none">
                        <p>{!! __('pages/sponsoring.paragraphes.one') !!}</p>
                        <p>{{ __('pages/sponsoring.paragraphes.two') }}</p>
                        <p>{{ __('pages/sponsoring.paragraphes.three') }}</p>
                        <p>{{ __('pages/sponsoring.paragraphes.four') }}</p>
                        <p>{{ __('pages/sponsoring.paragraphes.five') }}</p>
                    </div>
                </div>

                <livewire:components.sponsor-subscription />
            </div>
        </div>
    </x-container>
</div>
