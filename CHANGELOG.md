# Changelog

All notable changes to `laravel.cm` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## v3.3.0: AI News Digest & Docker Modernization - 2026-03-19

### Highlights

#### AI-Powered News Digest Generation

A new Filament cpanel page allows admins to generate tech news digest articles via AI (OpenAI, Anthropic). An AI agent crawls configured RSS feeds (Laravel News, Reddit, Dev.to, etc.), analyzes the week's content, and writes structured digest articles submitted for editorial review.

The generation UI features a real-time timeline (Redis polling) tracking each step: initialization with provider/model info, source crawling with per-URL status, article saving, and completion.

#### Real-Time Monitoring with Flux Timeline

Generation progress displayed using Flux UI's Timeline component with collapsible steps, provider/model icons, status badges (done/failed), and leader dots. Auto-resets after completion.

#### Docker Compose Modernization

Replaced Laravel Sail with a custom Docker Compose setup. Production stack includes dedicated containers for the app (FrankenPHP/Octane), schedule worker, queue worker, Reverb WebSocket server, and Nightwatch agent.

#### Laravel Reverb & Broadcasting Infrastructure

Installed and configured Laravel Reverb for WebSocket support with dedicated production Docker container and internal HTTP communication for the broadcaster.

### Added

- Filament cpanel page for AI news digest generation with real-time monitoring
- `GenerateNewsDigestJob` with structured JSON log entries in Redis
- `SaveAiGeneratedArticlesAction` — unified action for AI article creation
- `NewsWriter` AI agent with instructions, response parsing, and prompt builder
- `FetchRssFeed` RSS/Atom parser tool for the agent
- Telegram notification on generation completion
- `NewsDigestCacheKey` enum centralizing Redis/Cache keys
- CLI command `ai:news-digest` for scheduled weekly generation
- Navigation badge on ArticleResource showing pending article count
- SVG icons for AI providers (Anthropic, Claude, OpenAI, Gemini, DeepSeek, Ollama, xAI)
- Predefined model selection per provider
- Reverb container in production Docker Compose
- Laravel Echo and Pusher JS client
- Filament theme CSS with Flux UI and PurelineTheme integration

### Fixed

- Twitter card image showing site default instead of article image (inverted `blank()` condition)
- Twitter notification self-mentioning `@laravelcm` when author is the platform account

### Changed

- RSS sources externalized to `config/lcm.php`
- Tag create/edit switched from slideOver to modal
- Broadcasting uses internal Docker network for server-to-server communication
- Tag resolution optimized: single query instead of N+1
- Redis EXPIRE calls reduced in job logging
- Blade view pre-indexes log entries for polling performance

### Removed

- Laravel Sail dependency
- Volt package
- Dead `NewsDigestLogUpdated` broadcast event
- `phpstan-baseline.neon`

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
