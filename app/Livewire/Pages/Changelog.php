<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Actions\GetGithubContributorsAction;
use App\Actions\GetGithubReleasesAction;
use App\Data\ContributorData;
use App\Data\ReleaseData;
use App\Services\ReleaseBodyRenderer;
use ArchTech\SEO\SEOManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class Changelog extends Component
{
    private const string REPOSITORY_URL = 'https://github.com/laravelcm/laravel.cm';

    private GetGithubReleasesAction $getReleases;

    private GetGithubContributorsAction $getContributors;

    private ReleaseBodyRenderer $bodyRenderer;

    public function boot(GetGithubReleasesAction $getReleases, GetGithubContributorsAction $getContributors): void
    {
        $this->getReleases = $getReleases;
        $this->getContributors = $getContributors;
        $this->bodyRenderer = new ReleaseBodyRenderer(self::REPOSITORY_URL);
    }

    public function mount(): void
    {
        /** @var SEOManager $seoManager */
        $seoManager = seo();

        $seoManager
            ->title(__('pages/changelog.title'))
            ->description(__('pages/changelog.description'))
            ->url(route('changelog'));
    }

    public function render(): View
    {
        /** @var Collection<int, ReleaseData> $releases */
        $releases = ($this->getReleases)();

        /** @var Collection<int, ContributorData> $allContributors */
        $allContributors = ($this->getContributors)();

        return view('livewire.pages.changelog', [
            'releases' => $releases,
            'allContributors' => $allContributors,
            'repositoryUrl' => self::REPOSITORY_URL,
        ])->title(__('pages/changelog.title'));
    }

    public function renderBody(string $markdown): string
    {
        return $this->bodyRenderer->render($markdown);
    }
}
