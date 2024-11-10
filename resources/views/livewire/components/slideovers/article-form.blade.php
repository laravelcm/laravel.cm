<x-form-slider-over
    :title="$article->id ? $article->title : __('pages/article.new_article')"
    action="save"
>
    <div class="space-y-6">
        <div x-data="{ expanded: false }">
            <button
                @click="expanded = ! expanded"
                type="button"
                class="relative inline-flex items-center gap-2 px-4 py-3 rounded-lg text-sm font-medium leading-4 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100/70 dark:hover:bg-white/20"
            >
                <x-untitledui-alert-triangle class="size-4 text-yellow-500 dark:text-yellow-400" aria-hidden="true" />
                {{ __('pages/article.advice.title') }}
                <x-untitledui-chevron-down class="size-4" aria-hidden="true" />

                <span class="absolute top-0 right-0 flex size-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full size-3 bg-yellow-400"></span>
                </span>
            </button>

            <div class="mt-4 prose prose-sm prose-primary leading-5 max-w-none dark:prose-invert" x-show="expanded" x-collapse>
                <p>{{ __('pages/article.advice.content') }}</p>
                <p>{{ __('pages/article.advice.twitter') }}</p>
                <p>{!! __('pages/article.advice.submission') !!}</p>
            </div>
        </div>

        {{ $this->form }}
    </div>
</x-form-slider-over>
