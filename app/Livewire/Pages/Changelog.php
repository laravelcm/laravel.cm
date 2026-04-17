<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Actions\GetGithubContributorsAction;
use App\Actions\GetGithubReleasesAction;
use App\Data\ContributorData;
use App\Data\ReleaseData;
use ArchTech\SEO\SEOManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class Changelog extends Component
{
    private const string REPOSITORY_URL = 'https://github.com/laravelcm/laravel.cm';

    private GetGithubReleasesAction $getReleases;

    private GetGithubContributorsAction $getContributors;

    public function boot(GetGithubReleasesAction $getReleases, GetGithubContributorsAction $getContributors): void
    {
        $this->getReleases = $getReleases;
        $this->getContributors = $getContributors;
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
        $html = (string) md_to_html($markdown);

        $html = (string) preg_replace(
            '/href=(["\'])\s*(?:javascript|data|vbscript):[^"\']*\1/i',
            'href=$1#$1',
            $html,
        );

        $html = (string) preg_replace_callback(
            '/<a\s+([^>]*?)>/i',
            static function (array $match): string {
                $attributes = $match[1];

                if (preg_match('/href=(["\'])(https?:\/\/[^"\']+)\1/i', $attributes) !== 1) {
                    return $match[0];
                }

                if (preg_match('/\btarget=/i', $attributes) === 1 || preg_match('/\brel=/i', $attributes) === 1) {
                    return $match[0];
                }

                return '<a '.mb_rtrim($attributes).' target="_blank" rel="noopener noreferrer nofollow">';
            },
            $html,
        );

        return (string) preg_replace(
            '/(?<![\w\/])#(\d+)\b/',
            '<a href="'.self::REPOSITORY_URL.'/pull/$1" target="_blank" rel="noopener noreferrer nofollow">#$1</a>',
            $html,
        );
    }
}
