@props([
    'thread'
])

@php
    $acceptedAnswer = null;

    if ($thread->solution_reply_id && $thread->solution) {
        $acceptedAnswer = [
            '@type' => 'Answer',
            'text' => strip_tags($thread->solution->body),
            'dateCreated' => $thread->solution->created_at->toIso8601String(),
            'upvoteCount' => $thread->solution->reactions_count ?? 0,
            'author' => [
                '@type' => 'Person',
                'name' => $thread->solution->user->name,
                'url' => route('profile', $thread->solution->user->username),
            ],
        ];
    }

    $answers = $thread->replies()
        ->with('user')
        ->withCount('reactions')
        ->latest()
        ->limit(10)
        ->get()
        ->map(fn ($reply): array => [
            '@type' => 'Answer',
            'text' => strip_tags($reply->body),
            'dateCreated' => $reply->created_at->toIso8601String(),
            'upvoteCount' => $reply->reactions_count ?? 0,
            'author' => [
                '@type' => 'Person',
                'name' => $reply->user->name,
                'url' => route('profile', $reply->user->username),
            ],
        ])->toArray();

    $breadcrumbs = \Diglactic\Breadcrumbs\Breadcrumbs::generate('thread', $thread);
    $breadcrumbItems = $breadcrumbs->map(fn ($item, $index): array => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item->title,
        'item' => $item->url,
    ])->toArray();
@endphp

<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "QAPage",
      "mainEntity": {
        "@type": "Question",
        "name": {{ Js::from($thread->title) }},
        "text": {{ Js::from(strip_tags($thread->body)) }},
        "answerCount": {{ $thread->replies_count ?? 0 }},
        "upvoteCount": {{ $thread->reactions_count ?? 0 }},
        "dateCreated": {{ Js::from($thread->created_at->toIso8601String()) }},
        "author": {
          "@type": "Person",
          "name": {{ Js::from($thread->user->name) }},
          "url": {{ Js::from(route('profile', $thread->user->username)) }}
        },
        @if ($acceptedAnswer)
        "acceptedAnswer": {!! json_encode($acceptedAnswer, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!},
        @endif
        "suggestedAnswer": {!! json_encode($answers, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
      }
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": {!! json_encode($breadcrumbItems, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    }
  ]
}
</script>
