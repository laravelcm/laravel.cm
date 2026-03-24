# Sentinel

Content quality monitoring for Laravel applications. Scans your content for SEO issues, notifies authors, and auto-fixes after a configurable deadline.

## Installation

```bash
# Coming soon
```

## What it does

Sentinel monitors your Eloquent models for content quality issues that hurt SEO:

- **Missing HTTPS** — Markdown links like `[text](example.com)` without `https://`
- **Failed uploads** — Broken upload placeholders like `![image](Uploading...)`
- **Broken canonical URLs** — External canonical URLs that return 4XX or are unreachable

When issues are found, Sentinel notifies the content author by email and gives them a configurable deadline to fix. If the author doesn't act, Sentinel auto-fixes the content.

## How it works

```
sentinel:scan              → Detect issues in content body
sentinel:check-canonicals  → HTTP check external canonical URLs
sentinel:notify            → Email authors (grouped per user, one email)
sentinel:auto-fix          → Fix expired issues past their deadline
```

**Recommended schedule** (weekly, staggered):

```php
Schedule::command('sentinel:scan')->weeklyOn(1, '18:00');
Schedule::command('sentinel:check-canonicals')->weeklyOn(1, '18:10');
Schedule::command('sentinel:notify')->weeklyOn(1, '18:30');
Schedule::command('sentinel:auto-fix')->weeklyOn(1, '19:00');
```

## Setup

### 1. Publish config and run migrations

```bash
php artisan vendor:publish --tag=sentinel
php artisan migrate
```

### 2. Make your models scannable

Add the `Scannable` interface and `HasContentIssues` trait to any model with user-generated content:

```php
use Laravelcm\Sentinel\Contracts\Scannable;
use Laravelcm\Sentinel\Traits\HasContentIssues;

final class Article extends Model implements Scannable
{
    use HasContentIssues;
}
```

The trait scans the `body` column by default. Override `sentinelContentColumn()` if your model uses a different column:

```php
public function sentinelContentColumn(): string
{
    return 'content';
}
```

For canonical URL checking, override `sentinelCanonicalUrl()`:

```php
public function sentinelCanonicalUrl(): ?string
{
    return $this->canonical_url;
}
```

### 3. Register your models in config

```php
// config/sentinel.php

return [
    'deadline_days' => 30,

    'models' => [
        App\Models\Article::class,
        App\Models\Thread::class,
        App\Models\Discussion::class,
        App\Models\Reply::class,
    ],
];
```

## Configuration

| Key | Default | Description |
|---|---|---|
| `deadline_days` | `30` | Days before auto-fix kicks in. Configurable via `SENTINEL_DEADLINE_DAYS` env variable. |
| `models` | `[]` | Eloquent models to scan. Must implement `Scannable`. |

## Issue lifecycle

```
Detected → Notified (email sent, deadline set) → Resolved (author fixed it)
                                                → AutoFixed (deadline passed)
```

- **Detected** — Issue found during scan
- **Notified** — Author emailed, deadline starts
- **Resolved** — Author fixed the content (detected automatically on next scan)
- **AutoFixed** — Deadline passed, Sentinel fixed it

## Auto-fix behavior

| Issue type | Auto-fix action |
|---|---|
| Missing HTTPS | Adds `https://` prefix to the link |
| Failed upload | Removes the broken markdown reference |
| Broken canonical | No auto-fix (requires manual decision) |

## Translations

Sentinel ships with French and English translations for notification emails. Publish them to customize:

```bash
php artisan vendor:publish --tag=sentinel-translations
```

## Testing

```bash
php artisan test app-modules/sentinel/tests
```

## License

Proprietary.
