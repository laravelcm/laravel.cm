<?php

declare(strict_types=1);

use App\Spotlight\Commands\GoToArticles;
use App\Spotlight\Commands\GoToHome;
use App\Spotlight\Commands\ToggleTheme;
use App\Spotlight\SpotlightManager;
use Illuminate\Http\Request;

beforeEach(function (): void {
    $this->manager = new SpotlightManager;
    $this->request = Request::create('/');
});

describe(SpotlightManager::class, function (): void {
    it('registers a command', function (): void {
        $this->manager->register(GoToHome::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        expect($commands)->toHaveCount(1)
            ->and($commands[0]['id'])->toBe('go-to-home');
    });

    it('registers multiple commands', function (): void {
        $this->manager->register(GoToHome::class);
        $this->manager->register(GoToArticles::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        expect($commands)->toHaveCount(2);
    });

    it('registers command conditionally with registerIf', function (): void {
        $this->manager->registerIf(true, GoToHome::class);
        $this->manager->registerIf(false, GoToArticles::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        expect($commands)->toHaveCount(1)
            ->and($commands[0]['id'])->toBe('go-to-home');
    });

    it('registers command conditionally with registerUnless', function (): void {
        $this->manager->registerUnless(false, GoToHome::class);
        $this->manager->registerUnless(true, GoToArticles::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        expect($commands)->toHaveCount(1)
            ->and($commands[0]['id'])->toBe('go-to-home');
    });

    it('retrieves a command by id', function (): void {
        $this->manager->register(GoToHome::class);

        $command = $this->manager->getCommandById('go-to-home');

        expect($command)->toBeInstanceOf(GoToHome::class);
    });

    it('returns null for unknown command id', function (): void {
        $command = $this->manager->getCommandById('unknown');

        expect($command)->toBeNull();
    });

    it('generates kebab-case ids from class names', function (): void {
        $this->manager->register(GoToArticles::class);
        $this->manager->register(ToggleTheme::class);

        $commands = $this->manager->getVisibleCommands($this->request);
        $ids = array_column($commands, 'id');

        expect($ids)->toContain('go-to-articles', 'toggle-theme');
    });

    it('includes all required keys in command array', function (): void {
        $this->manager->register(GoToHome::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        expect($commands[0])->toHaveKeys(['id', 'name', 'description', 'icon', 'group', 'synonyms', 'dependencies', 'closesAfterExecute']);
    });

    it('reports closesAfterExecute correctly', function (): void {
        $this->manager->register(GoToHome::class);
        $this->manager->register(ToggleTheme::class);

        $commands = $this->manager->getVisibleCommands($this->request);

        $goToHome = collect($commands)->firstWhere('id', 'go-to-home');
        $toggleTheme = collect($commands)->firstWhere('id', 'toggle-theme');

        expect($goToHome['closesAfterExecute'])->toBeTrue()
            ->and($toggleTheme['closesAfterExecute'])->toBeFalse();
    });
});
