<div>
    <x-container class="line-x px-0">
        <header class="px-4 py-20 lg:py-28">
            <div class="flex items-center gap-3">
                <span class="inline-flex size-2 rounded-full bg-primary-500"></span>
                <span class="font-mono text-xs uppercase tracking-widest text-primary-600 dark:text-primary-400">
                    {{ __('pages/changelog.title') }}
                </span>
            </div>
            <h1 class="mt-4 font-heading text-3xl font-bold tracking-tight text-gray-900 lg:text-5xl dark:text-white">
                {{ __('pages/changelog.heading') }}
            </h1>
            <p class="mt-4 max-w-2xl text-base text-gray-600 lg:text-lg dark:text-gray-400">
                {{ __('pages/changelog.subheading') }}
            </p>
        </header>

        @if ($releases->isEmpty())
            <div class="mx-4 rounded-lg border border-dashed border-gray-300 bg-white/60 p-12 text-center text-gray-600 backdrop-blur dark:border-gray-700 dark:bg-gray-900/60 dark:text-gray-400">
                {{ __('pages/changelog.empty') }}
            </div>
        @else
            <div class="pb-20 lg:grid lg:grid-cols-[1fr_260px] lg:gap-x-8 lg:pb-28">
                <div class="px-4 space-y-16 lg:space-y-20">
                    @foreach ($releases as $release)
                        <section class="relative lg:grid lg:grid-cols-[140px_1fr] lg:gap-x-6">
                            <div class="relative lg:sticky lg:top-28 lg:self-start">
                                <span class="absolute top-1.5 z-10 size-2.5 -left-5.25 rounded-full bg-primary-500 ring-4 ring-gray-100 dark:ring-white/20"></span>
                                <time
                                    datetime="{{ $release->published_at->toIso8601String() }}"
                                    class="text-sm text-gray-600 dark:text-gray-400"
                                >
                                    {{ $release->published_at->isoFormat('LL') }}
                                </time>
                            </div>

                            <article id="{{ $release->tag_name }}" class="mt-6 scroll-mt-28 lg:mt-0">
                                <div>
                                    <a
                                        href="{{ $release->html_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center rounded-md bg-primary-50 px-2 py-0.5 font-mono text-xs font-medium text-primary-700 ring-1 ring-primary-200/60 transition hover:bg-primary-100 dark:bg-primary-500/10 dark:text-primary-300 dark:ring-primary-500/30 dark:hover:bg-primary-500/20"
                                    >
                                        {{ $release->tag_name }}
                                    </a>
                                </div>

                                <h2 class="mt-4 font-heading text-2xl font-bold tracking-tight text-gray-900 lg:text-4xl dark:text-white">
                                    {{ $release->name }}
                                </h2>

                                <div class="prose prose-emerald mt-8 dark:prose-invert prose-headings:font-heading prose-headings:scroll-mt-28 prose-h2:text-xl prose-h3:text-lg prose-a:text-primary-600 dark:prose-a:text-primary-400">
                                    {!! $this->renderBody($release->body) !!}
                                </div>

                                @if ($release->contributors->isNotEmpty())
                                    <div class="mt-10 flex items-center gap-2.5">
                                        <div class="flex -space-x-1.5">
                                            @foreach ($release->contributors as $contributor)
                                                <a
                                                    href="{{ $contributor->profileUrl() }}"
                                                    target="_blank"
                                                    rel="noopener noreferrer"
                                                    title="{{ '@' . $contributor->login }}"
                                                >
                                                    <img
                                                        src="{{ $contributor->avatar }}"
                                                        alt="{{ $contributor->login }}"
                                                        loading="lazy"
                                                        class="size-6 rounded-full ring-2 ring-white outline-2 outline-gray-200 dark:ring-gray-950 dark:outline-gray-800"
                                                    />
                                                </a>
                                            @endforeach
                                        </div>
                                        @if ($release->contributors->count() > 1)
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                {{ trans_choice('pages/changelog.contributors', $release->contributors->count(), ['count' => $release->contributors->count()]) }}
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </article>
                        </section>
                    @endforeach
                </div>

                @if ($allContributors->isNotEmpty())
                    <aside class="mt-16 lg:mt-0 lg:sticky lg:top-28 lg:self-start">
                        <div class="bg-white dark:bg-line-black border-t border-l border-line border-dotted">
                            <div class="px-4 py-3  bg-gray-50 dark:bg-gray-950 flex items-start gap-4">
                                <x-untitledui-code class="size-4 shrink-0 text-primary-600 dark:text-primary-500" aria-hidden="true" />
                                <p class="text-gray-900 dark:text-white text-xs font-mono uppercase">
                                    {{ __('pages/changelog.all_contributors') }}
                                </p>
                            </div>
                            <div class="p-4">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ __('pages/changelog.all_contributors_description') }}
                                </p>
                            </div>
                            <div class="border-y border-line">
                                <div class="flex flex-wrap gap-2 p-4">
                                    @foreach ($allContributors as $contributor)
                                        <flux:tooltip :content="'@' . $contributor->login">
                                            <a
                                                href="{{ $contributor->profileUrl() }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-block"
                                            >
                                                <img
                                                    src="{{ $contributor->avatar }}"
                                                    alt="{{ $contributor->login }}"
                                                    loading="lazy"
                                                    class="size-8 rounded-full ring-1 ring-gray-200 transition hover:ring-primary-500 dark:ring-white/10"
                                                />
                                            </a>
                                        </flux:tooltip>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </aside>
                @endif
            </div>
        @endif
    </x-container>
</div>
