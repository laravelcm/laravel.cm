# Changelog

All notable changes to `laravel.cm` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## v3.6.0: Laravel 13 Upgrade & WebP Support - 2026-04-17

### Highlights

#### Laravel 13 Upgrade

The application now runs on Laravel 13.5.0, bringing modern framework features and security patches.

**Framework & dependencies:**

- `laravel/framework` → `^13.0`
- `laravel/tinker` → `^3.0`
- `barryvdh/laravel-debugbar` → `^4.2.6` (v3 incompatible with L13)
- `laravelcm/laravel-subscriptions` → `^1.8.0`
- `laravel-notification-channels/telegram` → `^7.0`
- `laravelcm/gamify` widened to `^11|^12|^13`

**Laravel 13 modernization:**

- New eloquent attributes: `#[Fillable]`, `#[Hidden]` replace property declarations on `User` and `ContentIssue`
- New queue attributes: `#[Timeout]`, `#[UniqueFor]` replace property declarations on `GenerateNewsDigestJob`
- Middleware rename: `VerifyCsrfToken` → `PreventRequestForgery`

#### WebP Support for Article Covers

Article cover images are now automatically converted to WebP on upload via Spatie Media Library conversions. The WebP variant is served on article pages, listing cards, and editor previews — while the original format is preserved for external contexts (Telegram, email, RSS, Open Graph, Schema.org) where compatibility matters.

**Benefits:**

- 25–35% lighter than JPEG at equivalent visual quality
- Core Web Vitals (LCP) improvement → better SEO ranking signals
- Lower S3 bandwidth consumption

**Safe rollout:** `Article::getCoverImageUrl()` helper falls back to the original format when the WebP conversion hasn't been generated yet, so existing articles continue to display normally during and after deployment.

### ⚠️ Deployment notes

Laravel 13 changes default cache key prefix and session cookie name fallbacks:

- Cache prefix: `laravelcm_cache_` → `laravelcm-cache-`
- Session cookie: `Str::slug` → `Str::snake`

If `CACHE_PREFIX` and `SESSION_COOKIE` are not explicitly set in production `.env`, the cache will be invalidated and active sessions logged out at deploy.

After deploy, regenerate WebP variants for existing articles:

```bash
docker compose -f docker-compose.prod.yml exec laravelcm artisan media-library:regenerate --only=webp

```
### Added

- WebP conversion for article cover images via Spatie Media Library (#527)
- `Article::getCoverImageUrl()` helper with WebP-first fallback (#527)
- Explicit WebP acceptance in article form validation and file input (#527)

### Changed

- Upgraded to Laravel 13.5.0 with all related dependency bumps (#527)
- Rector config now uses `withComposerBased(laravel: true)` for auto-loaded version sets (#527)
- Migrated `User`, `ContentIssue` to `#[Hidden]` / `#[Fillable]` attributes (#527)
- Migrated `GenerateNewsDigestJob` to `#[Timeout]` / `#[UniqueFor]` attributes (#527)
- Typed `PointType` and all gamify point subclasses properties (preserves optional payee semantics) (#527)
- Typed `BaseExtension` / `TorchlightExtension` node parameters with `League\CommonMark\Node` (#527)
- Factories cleaned of phantom `$attributes ??` fallbacks (#527)

### Fixed

- Unnecessary nullsafe operators removed on non-nullable `User` relation in `YouWereMentioned` notification (#527)
- Config files now cast `env()` return values to `string` for `Str::slug` and `explode` (#527)
- 25+ entries removed from PHPStan baseline thanks to proper type hints

## v3.5.0: Article Sponsoring & Telegram Fix - 2026-04-14

### Highlights

#### Article Sponsoring System

Admins and moderators can now sponsor articles directly from the Filament admin panel. Sponsored articles are highlighted on the homepage and display a golden "Sponsorisé" badge.

**How it works:**

- **Sponsor** — Sets `is_sponsored = true` and records the sponsoring date. The article appears first on the homepage.
- **Unsponsor** — Removes the article from homepage priority but preserves the sponsoring date and badge for historical reference.
- Homepage cache is invalidated only on specific admin actions (approve, sponsor, unsponsor, delete) — not on every article edit.

#### Telegram Notification Fix

Fixed a bug where the Telegram notification for submitted articles was sent 4-5 times. The notification is now dispatched only on the first submission — editing an already-submitted article no longer re-triggers it. The toast message also correctly shows "Article updated" instead of "Thank you for submitting" when editing a published article.

### Added

- Sponsor/unsponsor actions in Filament admin panel with confirmation modals (#524)
- `sponsor()` method in `ArticlePolicy` for admin/moderator authorization (#524)
- `isActivelySponsored()`, `activelySponsored()`, `sponsoredFirst()` query scopes (#524)
- "Sponsorisé" badge on article cards (homepage, listing, single post) (#524)
- `is_sponsored` column in Filament articles table (#524)
- Targeted home cache invalidation on approve, sponsor, unsponsor, and delete actions (#524)

### Fixed

- Duplicate Telegram notification sent 4-5 times on article submission (#523)
- Wrong toast message shown when updating an already-submitted article (#523)
- Sentinel email formatting issues (#522)

### Changed

- Homepage articles sorted by sponsoring status first, then by publication date (#524)
- Repository setup improvements (#522)

## v3.4.2: SEO Audit Fixes & Sentinel Module - 2026-03-24

### Highlights

#### SEO Audit Fixes (Ahrefs)

Health score was 5/100 with 2,108 issues. This release addresses the critical ones:

- **Double title tags (248 pages)** — Removed duplicate `<title>` from base layout. All pages now use a single title via `archtechx/laravel-seo` manager.
- **Broken images (222 references)** — Created `app:clean-broken-images` command to remove orphaned `/storage/images/` markdown references from articles, threads, discussions, and replies (pre-S3 migration leftovers).
- **Broken links (10 pages)** — Fixed markdown links missing `https://` prefix, dead `/slack` route replaced with `/discord`, and broken canonical URLs reset to null. Applied via data migration.
- **Non-canonical pages in sitemap (20)** — Articles with external canonical URLs are now excluded from sitemap generation.

#### Sentinel Module

New `app-modules/sentinel/` module for automated content quality monitoring. Scans content weekly for SEO issues, notifies authors by email, and auto-fixes after a 30-day deadline.

**Issue types detected:** missing `https://` in links, failed upload placeholders (`Uploading...`), broken external canonical URLs (via HTTP HEAD check with GET fallback).

**Lifecycle:** `Detected → Notified (email + 30-day deadline) → Resolved (author fixed) | AutoFixed (deadline passed)`

**Commands:**

- `sentinel:scan` — Scan content for quality issues
- `sentinel:check-canonicals` — HTTP check external canonical URLs
- `sentinel:notify` — Email authors grouped by user
- `sentinel:auto-fix` — Fix expired issues past deadline

Scheduled weekly on Mondays at 18:00 (WAT). Models implementing `Scannable`: Article, Thread, Discussion, Reply.

25 Pest tests, PHPStan level 9, fr/en translations included.

### Added

- Sentinel module with `Scannable` interface, `HasContentIssues` trait, `ContentIssue` morphable model
- `ScanContentAction` and `AutoFixContentAction` for detection and correction logic
- `ContentIssuesDetectedNotification` queued mail notification with translations
- `CleanBrokenImageReferences` command with `--dry-run` mode
- Data migration to fix broken links, dead routes, and invalid canonical URLs in existing content

### Changed

- Base layout delegates title to SEO manager instead of manual `<title>` tag
- `GenerateArticlesSitemapCommand` excludes articles with external canonical URLs
- Rector fixes applied to Job classes (queue traits modernization)
- PHPStan baseline updated for sitemap command signature change

### Fixed

- 248 pages with duplicate `<title>` tags
- 222 broken `/storage/images/` markdown image references
- 10 internal links returning 404 (missing https, dead routes, broken canonicals)
- 20 non-canonical pages included in sitemap

## v3.4.1: Plausible Analytics - 2026-03-24

### Highlights

#### Plausible Analytics (Self-Hosted)

Plausible Analytics is now integrated alongside Google Analytics for privacy-friendly traffic tracking. The self-hosted instance runs on `analytics.universy.app` and is loaded only in production via the `@production` directive.

Optional measurements enabled: **outbound link tracking** and **custom events** — useful for monitoring external clicks and user interactions for future sponsor media kits.

### Added

- Plausible Analytics self-hosted script in `base.blade.php` with `outbound-links` and `tagged-events` extensions
- Plausible queue helper (`window.plausible`) for deferred custom event calls

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
