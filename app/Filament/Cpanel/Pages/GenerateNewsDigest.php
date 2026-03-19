<?php

declare(strict_types=1);

namespace App\Filament\Cpanel\Pages;

use App\Jobs\GenerateNewsDigestJob;
use App\Models\User;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Laravel\Ai\Enums\Lab;
use UnitEnum;

final class GenerateNewsDigest extends Page
{
    private const array PROVIDER_ICONS = [
        'anthropic' => 'app-anthropic',
        'openai' => 'app-open-ai',
        'gemini' => 'app-gemini',
        'deepseek' => 'app-deepseek',
        'ollama' => 'app-ollama',
        'xai' => 'app-xai',
    ];

    private const array MODEL_ICONS = [
        'anthropic' => 'app-claude-ai',
        'openai' => 'app-open-ai',
        'gemini' => 'app-gemini',
        'deepseek' => 'app-deepseek',
        'ollama' => 'app-ollama',
        'xai' => 'app-xai',
    ];

    private const array PROVIDER_MODELS = [
        'openai' => [
            'gpt-4.1-mini' => 'GPT-4.1 Mini',
            'gpt-4.1' => 'GPT-4.1',
        ],
        'anthropic' => [
            'claude-haiku-4-5-20251001' => 'Claude Haiku 4.5',
            'claude-sonnet-4-5-20250514' => 'Claude Sonnet 4.5',
        ],
    ];

    public string $provider = 'openai';

    public string $aiModel = 'gpt-4.1-mini';

    public int $batchSize = 4;

    /** @var array<int, string> */
    public array $sources = [];

    protected static string|null|BackedEnum $navigationIcon = 'phosphor-robot-duotone';

    protected static string|null|UnitEnum $navigationGroup = 'Contenu';

    protected static ?string $title = 'Digest IA';

    protected ?string $subheading = 'Générez automatiquement des articles de veille technologique en parcourant vos sources RSS via l\'IA.';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.cpanel.pages.generate-news-digest';

    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user !== null && ($user->isAdmin() || $user->isModerator());
    }

    public function updatedProvider(): void
    {
        $models = self::PROVIDER_MODELS[$this->provider] ?? [];
        $this->aiModel = array_key_first($models) ?? '';
    }

    /**
     * @return array<string, string>
     */
    public function getAvailableModels(): array
    {
        return self::PROVIDER_MODELS[$this->provider] ?? [];
    }

    public function mount(): void
    {
        /** @var list<string> $defaultSources */
        $defaultSources = config('lcm.news_digest.default_sources', []);
        $this->sources = $defaultSources;
    }

    public function generate(): void
    {
        if ($this->getStatus() === 'running') {
            Notification::make()
                ->warning()
                ->title('Génération deja en cours')
                ->body('Veuillez patienter la fin de la génération actuelle.')
                ->send();

            return;
        }

        $this->validate([
            'provider' => ['required', 'string'],
            'aiModel' => ['required', 'string'],
            'batchSize' => ['required', 'integer', 'min:1', 'max:10'],
            'sources' => ['required', 'array', 'min:1'],
            'sources.*' => ['required', 'url'],
        ]);

        Cache::put('news-digest:status', 'running', now()->addHour());

        dispatch(new GenerateNewsDigestJob(provider: $this->provider, model: $this->aiModel, batchSize: $this->batchSize, sources: $this->sources));

        Notification::make()
            ->success()
            ->title('Generation lancée')
            ->body('Le digest est en cours de génération. Vous pouvez suivre la progression ci-dessous.')
            ->send();
    }

    public function addSource(): void
    {
        $this->sources[] = '';
    }

    public function removeSource(int $index): void
    {
        unset($this->sources[$index]);

        /** @var list<string> $reindexed */
        $reindexed = array_values($this->sources);
        $this->sources = $reindexed;
    }

    public function getStatus(): string
    {
        /** @var string */
        return Cache::get('news-digest:status', 'idle');
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getLogEntries(): array
    {
        /** @var list<string> $raw */
        $raw = Redis::lrange('news-digest:logs', 0, -1) ?: [];

        return array_map(
            fn (string $json): array => (array) json_decode($json, true),
            $raw,
        );
    }

    /**
     * @return array<string, array{label: string, icon: string|null}>
     */
    public function getAvailableProviders(): array
    {
        /** @var array<string, array{key?: string}> $providers */
        $providers = config('ai.providers', []);

        return collect($providers)
            ->filter(fn (array $config): bool => filled($config['key'] ?? null))
            ->keys()
            ->mapWithKeys(fn (string $key): array => [
                $key => [
                    'label' => Lab::from($key)->name,
                    'icon' => self::PROVIDER_ICONS[$key] ?? null,
                ],
            ])
            ->all();
    }

    /**
     * @return array{count?: int, duration?: int, provider?: string, model?: string}|null
     */
    public function getResult(): ?array
    {
        /** @var array{count?: int, duration?: int, provider?: string, model?: string}|null */
        return Cache::get('news-digest:result');
    }

    public function getProviderIcon(?string $key = null): ?string
    {
        return self::PROVIDER_ICONS[$key ?? $this->provider] ?? null;
    }

    public function getModelIcon(?string $providerKey = null): ?string
    {
        return self::MODEL_ICONS[$providerKey ?? $this->provider] ?? null;
    }

    public function resetDigest(): void
    {
        Redis::del('news-digest:logs');
        Cache::forget('news-digest:status');
        Cache::forget('news-digest:result');
    }
}
