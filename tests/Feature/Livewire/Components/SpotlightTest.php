<?php

declare(strict_types=1);

use App\Livewire\Components\Spotlight;
use App\Spotlight\Commands\GoToHome;
use App\Spotlight\Commands\SearchArticles;
use App\Spotlight\Commands\ToggleTheme;
use App\Spotlight\SpotlightManager;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->manager = resolve(SpotlightManager::class);
});

describe(Spotlight::class, function (): void {
    it('renders successfully', function (): void {
        Livewire::test(Spotlight::class)
            ->assertStatus(200);
    });

    it('passes registered commands to the view', function (): void {
        $this->manager->register(GoToHome::class);

        $component = Livewire::test(Spotlight::class);

        expect($component->viewData('commands'))->not->toBeEmpty();
    });

    it('executes a navigation command', function (): void {
        $this->manager->register(GoToHome::class);

        Livewire::test(Spotlight::class)
            ->call('executeCommand', 'go-to-home')
            ->assertRedirect(route('home'));
    });

    it('ignores unknown command ids', function (): void {
        Livewire::test(Spotlight::class)
            ->call('executeCommand', 'unknown-command')
            ->assertNoRedirect();
    });

    it('executes toggle theme for authenticated user', function (): void {
        $user = $this->login();
        $user->settings(['theme' => 'light']);

        $this->manager->register(ToggleTheme::class);

        Livewire::test(Spotlight::class)
            ->call('executeCommand', 'toggle-theme')
            ->assertDispatched('theme-changed');

        $user->refresh();

        expect($user->setting('theme'))->toBe('dark');
    });

    it('toggles theme back to light when currently dark', function (): void {
        $user = $this->login();
        $user->settings(['theme' => 'dark']);

        $this->manager->register(ToggleTheme::class);

        Livewire::test(Spotlight::class)
            ->call('executeCommand', 'toggle-theme');

        $user->refresh();

        expect($user->setting('theme'))->toBe('light');
    });

    it('dispatches toggle for guest theme', function (): void {
        $this->manager->register(ToggleTheme::class);

        Livewire::test(Spotlight::class)
            ->call('executeCommand', 'toggle-theme')
            ->assertDispatched('theme-changed', 'toggle');
    });

    it('sanitizes search query', function (): void {
        $this->manager->register(SearchArticles::class);

        Livewire::test(Spotlight::class)
            ->call('searchDependency', 'search-articles', 'article', '<script>alert("xss")</script>')
            ->assertSet('dependencyQueryResults', []);
    });

    it('rejects empty search query', function (): void {
        $this->manager->register(SearchArticles::class);

        Livewire::test(Spotlight::class)
            ->call('searchDependency', 'search-articles', 'article', '')
            ->assertSet('dependencyQueryResults', []);
    });

    it('rejects invalid dependency name', function (): void {
        $this->manager->register(SearchArticles::class);

        Livewire::test(Spotlight::class)
            ->call('searchDependency', 'search-articles', 'invalid-dependency', 'test')
            ->assertSet('dependencyQueryResults', []);
    });

    it('rejects search for command without dependencies', function (): void {
        $this->manager->register(GoToHome::class);

        Livewire::test(Spotlight::class)
            ->call('searchDependency', 'go-to-home', 'article', 'test')
            ->assertSet('dependencyQueryResults', []);
    });

    it('hides auth-only commands from guests', function (): void {
        $this->manager->register(GoToHome::class);

        $commands = $this->manager->getVisibleCommands(request());
        $ids = array_column($commands, 'id');

        expect($ids)->toContain('go-to-home');
    });

    it('includes closesAfterExecute in command data', function (): void {
        $this->manager->register(GoToHome::class);
        $this->manager->register(ToggleTheme::class);

        $commands = $this->manager->getVisibleCommands(request());

        $goToHome = collect($commands)->firstWhere('id', 'go-to-home');
        $toggleTheme = collect($commands)->firstWhere('id', 'toggle-theme');

        expect($goToHome['closesAfterExecute'])->toBeTrue()
            ->and($toggleTheme['closesAfterExecute'])->toBeFalse();
    });
});
