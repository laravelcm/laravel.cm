<?php

declare(strict_types=1);

namespace App\Livewire\Traits;

use App\Markdown\SuspiciousContentDetector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

trait RateLimitsContentCreation
{
    protected function ensureIsNotSpammingContent(string $bucket, int $maxAttempts = 5, int $decaySeconds = 600): void
    {
        $key = $this->contentRateLimitKey($bucket);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'form' => __('Trop de contenus envoyés. Veuillez réessayer dans :seconds secondes.', ['seconds' => $seconds]),
            ])->status(429);
        }

        RateLimiter::hit($key, $decaySeconds);
    }

    /**
     * @return array<int, string> List of detection reasons (empty if content is clean)
     */
    protected function detectSuspiciousContent(string $body, ?string $title = null): array
    {
        $combined = mb_trim(($title ?? '').' '.$body);

        if ($combined === '') {
            return [];
        }

        /** @var SuspiciousContentDetector $detector */
        $detector = resolve(SuspiciousContentDetector::class);

        $reasons = $detector->analyse($combined);

        if ($reasons !== []) {
            Log::warning('Suspicious content detected', [
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'reasons' => $reasons,
                'title' => $title,
            ]);
        }

        return $reasons;
    }

    protected function rejectIfContentIsSuspicious(string $body, ?string $title = null): void
    {
        if ($this->detectSuspiciousContent($body, $title) !== []) {
            throw ValidationException::withMessages([
                'form' => __('Votre contenu contient des liens suspects. Veuillez les retirer et réessayer.'),
            ]);
        }
    }

    private function contentRateLimitKey(string $bucket): string
    {
        $identifier = Auth::id() ?? request()->ip() ?? 'guest';

        return sprintf('content-creation:%s:%s', $bucket, (string) $identifier);
    }
}
