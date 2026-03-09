# Changelog

All notable changes to `laravel.cm` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## v3.2.4: Telegram Notification Polish - 2026-03-09

### Highlights

#### Richer Telegram posts for published articles

`PostArticleToTelegram` now sends the article cover image when one is present. Previously it
dispatched a plain text message with only the title and URL. It now uses `TelegramFile::photo()`
and includes the title, a 200-character plain-text excerpt, and a link in the caption:

```php
return TelegramFile::create()
    ->to('@laravelcm')
    ->photo($imageUrl)
    ->content("*{$this->article->title}*\n\n_{$this->article->excerpt(200)}_\n\n{$url}");

```
Articles without a cover still fall back to a `TelegramMessage`.


---

#### Admin submission alerts now include author and excerpt

`ArticleSubmitted` — the queued notification sent to the Telegram admin channel when a new article
is submitted for review — now formats its message with a structured `content()` method: it shows
the article title, a 200-character excerpt, and a link back to the author's profile. A "Voir
l'article" inline button is also attached. When a cover image exists the notification is delivered
as a `TelegramFile`, otherwise as a `TelegramMessage`.


---

#### Approved articles no longer re-trigger the submission event

Editing and re-saving an already-approved article used to fire
`ArticleWasSubmittedForApproval` again, flooding admins with redundant Telegram alerts.
`ArticleForm::save()` now guards the event dispatch with `! $article->isApproved()`, so the event
fires only for articles that are genuinely awaiting a first review.


---

### Bug Fixes

* fix(notifications): send article cover via `TelegramFile` in `PostArticleToTelegram` when media is present by @mckenziearts in [#506](https://github.com/laravelcm/laravel.cm/pull/506)
* fix(notifications): add title, excerpt and inline button to `ArticleSubmitted` Telegram notification by @mckenziearts in [#506](https://github.com/laravelcm/laravel.cm/pull/506)
* fix(notifications): skip `ArticleWasSubmittedForApproval` event when article is already approved to prevent duplicate admin alerts by @mckenziearts in [#506](https://github.com/laravelcm/laravel.cm/pull/506)
* fix: remove stale PHPStan baseline entries for `ArticleSubmitted` after notification refactor by @mckenziearts

## v3.2.3 - 2026-03-09

### What's Changed

* fix(ci): fix release workflows triggers and changelog auto-commit by @mckenziearts in https://github.com/laravelcm/laravel.cm/pull/505

**Full Changelog**: https://github.com/laravelcm/laravel.cm/compare/v3.2.2...v3.2.3
