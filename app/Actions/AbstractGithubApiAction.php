<?php

declare(strict_types=1);

namespace App\Actions;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

abstract class AbstractGithubApiAction
{
    abstract protected function endpoint(): string;

    /**
     * @return array<string, int|string>
     */
    abstract protected function queryParameters(): array;

    abstract protected function errorLogPrefix(): string;

    /**
     * @return array<int, array<string, mixed>>|null
     */
    protected function fetch(): ?array
    {
        /** @var string|null $token */
        $token = config('services.github.token');

        try {
            /** @var Response $response */
            $response = Http::when(
                filled($token),
                fn ($http) => $http->withToken($token), // @phpstan-ignore-line
            )
                ->acceptJson()
                ->timeout(5)
                ->retry(2, 200, throw: false)
                ->get($this->endpoint(), $this->queryParameters());
        } catch (ConnectionException) {
            Log::warning($this->errorLogPrefix().': connection error');

            return null;
        } catch (Throwable $exception) {
            Log::warning($this->errorLogPrefix(), ['class' => $exception::class]);

            return null;
        }

        if ($response->failed()) {
            Log::warning($this->errorLogPrefix().': non-2xx response', ['status' => $response->status()]);

            return null;
        }

        /** @var array<int, array<string, mixed>> $payload */
        $payload = $response->json();

        return $payload;
    }
}
