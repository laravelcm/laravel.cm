@props([
    'article'
])

@php
    $breadcrumbs = \Diglactic\Breadcrumbs\Breadcrumbs::generate('article', $article);
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
      "@type": "Article",
      "headline": {{ Js::from($article->title) }},
      "description": {{ Js::from($article->excerpt(160)) }},
      "image": {{ Js::from($article->getFirstMediaUrl('media') ?: asset('/images/socialcard.png')) }},
      "datePublished": {{ Js::from($article->published_at?->toIso8601String()) }},
      "dateModified": {{ Js::from($article->updated_at->toIso8601String()) }},
      "author": {
        "@type": "Person",
        "name": {{ Js::from($article->user->name) }},
        "url": {{ Js::from(route('profile', $article->user->username)) }}
      },
      "publisher": {
        "@type": "Organization",
        "name": "Laravel Cameroun",
        "logo": {
          "@type": "ImageObject",
          "url": {{ Js::from(asset('/images/logo.svg')) }}
        }
      },
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": {{ Js::from($article->canonicalUrl()) }}
      },
      "wordCount": {{ str_word_count(strip_tags($article->body)) }},
      "articleBody": {{ Js::from(strip_tags($article->body)) }},
      "keywords": {{ Js::from($article->tags->pluck('name')->implode(', ')) }}
    },
    {
      "@type": "BreadcrumbList",
      "itemListElement": {!! json_encode($breadcrumbItems, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    }
  ]
}
</script>
