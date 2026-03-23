# Changelog

All notable changes to `laravel.cm` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## v3.4.0: Spotlight Command Palette & Typesense Search - 2026-03-23

### Highlights

#### Typesense Full-Text Search

Laravel Scout is now configured with the Typesense driver. Four models are indexed and searchable: Article (133 docs), Thread (89), Discussion (32), and User (634). Each model defines a `toSearchableArray()` with the relevant fields and a `shouldBeSearchable()` guard — only published articles and verified, non-banned users are indexed.

Typesense collection schemas are defined in `config/scout.php` with typed fields, facets on tags/channels, and `query_by` configuration. Search indexing runs asynchronously via a dedicated Redis queue (`search`), and the Docker production queue worker has been updated to listen on `default,media,search`.

#### Spotlight Command Palette (Cmd+K)

A custom command palette inspired by wire-elements/spotlight is now available across the entire site. Press `Cmd+K` (Mac) or `Ctrl+K` (Windows/Linux) to open it.

The palette has two layers: Fuse.js handles instant client-side fuzzy filtering of registered commands (navigation, actions), while Typesense powers the content search commands that drill into Articles, Forum Threads, Discussions, and Users with a breadcrumb UI.

Commands are PHP classes extending `SpotlightCommand`. Each declares its name, icon, group, synonyms, and an `execute()` method. Search commands define `dependencies()` for drill-down and `search{Name}()` methods that query Typesense.

#### SpotlightManager — Octane-Compatible Command Registry

Commands are managed by a `SpotlightManager` class registered as a `scoped` singleton in the container — safe for Laravel Octane. Commands are registered in `AppServiceProvider` with `register()`, `registerIf()`, or `registerUnless()`. Lookup by ID is O(1) via an indexed array.

#### Security Hardening

The Spotlight Livewire component enforces three layers of protection on search:

1. **Query sanitization** — `strip_tags()` + `mb_substr()` capped at 100 characters
2. **Rate limiting** — 30 requests/minute keyed by authenticated user ID or IP
3. **Dependency validation** — only dependency IDs declared by the command are accepted

Theme toggling validates against an allowlist and uses the existing `HasSettings` trait for persistence.

### Added

- Laravel Scout with Typesense driver, `toSearchableArray` and `shouldBeSearchable` on Article, Thread, Discussion, User
- Typesense collection schemas with facets, sorting fields, and query_by config in `config/scout.php`
- `SpotlightCommand` abstract class with kebab-case ID generation, `closesAfterExecute()`, grouped commands
- `SpotlightManager` with `register()`, `registerIf()`, `registerUnless()`, `getCommandById()`, `getVisibleCommands()`
- `SpotlightSearchResult` DTO with image and `SpotlightResultOptions` (badge label + color)
- `SpotlightCommandDependencies` and `SpotlightCommandDependency` for drill-down search flow
- Navigation commands: GoToArticles, GoToForum, GoToDiscussions, GoToHome, GoToAbout, GoToRules
- Search commands: SearchArticles, SearchThreads, SearchDiscussions, SearchUsers (with avatar + XP badge)
- ToggleTheme command with `closesAfterExecute: false` and user settings persistence
- Fuse.js dependency for client-side command filtering
- `spotlight.js` Alpine component with keyboard navigation, scroll-to-selected, dependency mode
- Search trigger button in header with `⌘K` hint (desktop) and magnifying glass icon (mobile)
- Translation files `lang/fr/command-palette.php` and `lang/en/command-palette.php`
- 22 Pest tests covering SpotlightManager and Spotlight Livewire component
- AI coding guidelines in `.ai/guidelines/` (question handling + coding rules)
- Fuse.js npm dependency

### Fixed

- `ReferrerPolicy` changed from `no-referrer` to `strict-origin-when-cross-origin` — fixes YouTube embed Error 153 caused by missing Referer header
- `CacheHeaders` middleware now only sets public cache headers on successful (2xx) responses — 404 pages were cached for 60s by browsers/CDN, causing published articles to remain inaccessible
- `ArticleObserver` cache invalidation key aligned with `SinglePost` cache key format (`article.{id}.{created_at_timestamp}`)
- Scout queue connection reads `QUEUE_CONNECTION` from environment instead of hardcoded `redis`

### Changed

- Docker production queue worker updated to listen on `default,media,search`
- `phpunit.xml` DB_HOST and DB_PORT removed — delegated to `.env.testing` for local/CI flexibility
- Removed `Searchable` trait from Reply and Enterprise models (not relevant for search)
- Old Spotlight stub files removed (`app/Spotlight/*.stub`)
- `/docs` directory added to `.gitignore`

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
