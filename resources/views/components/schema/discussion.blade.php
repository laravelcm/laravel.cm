@props([
    'discussion'
])

@php
    $comments = $discussion->replies()
        ->with('user')
        ->latest()
        ->limit(10)
        ->get()
        ->map(fn ($reply): array => [
            '@type' => 'Comment',
            'text' => strip_tags($reply->body),
            'dateCreated' => $reply->created_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $reply->user->name,
                'url' => route('profile', $reply->user->username),
            ],
        ])->toArray();

    $breadcrumbs = \Diglactic\Breadcrumbs\Breadcrumbs::generate('discussion', $discussion);
    $breadcrumbItems = $breadcrumbs->map(fn ($item, $index): array => [
        '@type' => 'ListItem',
        'position' => $index + 1,
        'name' => $item->title,
        'item' => $item->url,
    ])->toArray();
@endphp

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "DiscussionForumPosting",
      "headline": {{ Js::from($discussion->title) }},
      "text": {{ Js::from(strip_tags($discussion->body)) }},
      "datePublished": {{ Js::from($discussion->created_at->toIso8601String()) }},
      "dateModified": {{ Js::from($discussion->updated_at->toIso8601String()) }},
      "author": {
        "@type": "Person",
        "name": {{ Js::from($discussion->user->name) }},
        "url": {{ Js::from(route('profile', $discussion->user->username)) }}
      },
      "interactionStatistic": [
        {
          "@type": "InteractionCounter",
          "interactionType": "https://schema.org/CommentAction",
          "userInteractionCount": {{ $discussion->replies_count ?? 0 }}
        },
        {
          "@type": "InteractionCounter",
          "interactionType": "https://schema.org/LikeAction",
          "userInteractionCount": {{ $discussion->likesCount ?? 0 }}
        }
      ],
      "comment": {!! json_encode($comments, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": {!! json_encode($breadcrumbItems, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    }
  ]
}
</script>
