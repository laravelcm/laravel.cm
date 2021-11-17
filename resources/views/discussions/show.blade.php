@title($discussion->title)

@extends('layouts.default')

@section('body')

    <div class="relative lg:grid lg:grid-cols-12 lg:gap-10">
        <div class="lg:col-span-8">
            <header class="space-y-5 border-b border-skin-base">
                <div>
                    <h1 class="text-2xl font-extrabold text-skin-inverted tracking-tight font-sans sm:text-3xl sm:leading-8">{{ $discussion->title }}</h1>
                    <div class="mt-2 sm:flex sm:items-center space-x-4">
                        <span class="inline-flex items-center justify-center text-skin-base bg-skin-card-gray h-8 w-8 rounded-full">
                            <x-heroicon-s-tag class="h-5 w-5" />
                        </span>
                        @if ($discussion->tags->isNotEmpty())
                            <div class="flex items-center space-x-2">
                                @foreach ($discussion->tags as $tag)
                                    <x-articles.tag :tag="$tag" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="relative pb-8">
                    <div class="relative flex space-x-3">
                        <div class="relative">
                            <img class="h-10 w-10 rounded-full bg-skin-card-gray flex items-center justify-center ring-8 ring-body" src="{{ $discussion->author->profile_photo_url }}" alt="">
                            <span class="absolute top-5 -right-1 bg-skin-body rounded-tl px-0.5 py-px">
                                <x-heroicon-s-chat-alt class="h-5 w-5 text-skin-muted" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <div>
                                    <p class="text-sm text-skin-inverted font-medium">
                                        {{ $discussion->author->name }}
                                    </p>
                                </div>
                                <div class="mt-1 text-sm whitespace-nowrap text-skin-muted font-normal">
                                    <time datetime="{{ $discussion->created_at->format('Y-m-d') }}">Crée {{ $discussion->created_at->diffForHumans() }}</time>
                                </div>
                            </div>
                            <div class="text-sm prose md:prose-lg prose-green text-skin-base mx-auto max-w-none">
                                <x-markdown-content :content="$discussion->body" />
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="py-6 flex items-center justify-between">
                <p class="text-skin-inverted font-semibold font-sans" id="comments-count">Commentaires ({{ $discussion->replies_count }})</p>
                @auth
                    <livewire:discussions.subscribe :discussion="$discussion" />
                @endauth
            </div>
            <div class="mt-8" id="discussions-replies"></div>
        </div>
        <div class="hidden lg:block lg:col-start-10 lg:col-span-3">
            @include('discussions._contributions')
        </div>
    </div>

@endsection
