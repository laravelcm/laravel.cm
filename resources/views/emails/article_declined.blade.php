<x-mail::message>

<x-mail::panel>

{{ __('emails/article.article_declined.head',  ['title' => $article->title]) }}

{{ $article->reason }}

{{ __('emails/article.article_declined.recommandation_body') }}

{{ __('emails/article.article_declined.recommandation_1') }}
{{ __('emails/article.article_declined.recommandation_2') }}
{{ __('emails/article.article_declined.recommandation_3') }}

<x-mail::button :url="route('articles.show', $article)">
{{ __('emails/article.article_declined.button_update_article') }}
</x-mail::button>

{{ __('emails/article.article_declined.help') }}

</x-mail::panel>

<p>
    {{ __('emails/article.article_declined.closing') }}  <br>
    {{ __('emails/article.article_declined.team') }}
</p>

</x-mail::message>
