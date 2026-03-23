<?php

declare(strict_types=1);

namespace App\Spotlight\Commands;

use App\Livewire\Components\Spotlight;
use App\Models\User;
use App\Spotlight\SpotlightCommand;
use App\Spotlight\SpotlightCommandDependencies;
use App\Spotlight\SpotlightCommandDependency;
use App\Spotlight\SpotlightResultOptions;
use App\Spotlight\SpotlightSearchResult;
use Illuminate\Support\Collection;

final class SearchUsers extends SpotlightCommand
{
    protected ?string $icon = 'heroicon-o-users';

    protected ?string $group = null;

    protected array $synonyms = ['user', 'membre', 'développeur', 'profil', 'search'];

    public function getName(): string
    {
        return __('global.members');
    }

    public function dependencies(): SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('user')
                    ->setPlaceholder(__('command-palette.placeholder'))
            );
    }

    /**
     * @return Collection<int, SpotlightSearchResult>
     */
    public function searchUser(string $query): Collection
    {
        return User::search($query)
            ->take(10)
            ->get()
            ->map(fn (User $user): SpotlightSearchResult => new SpotlightSearchResult(
                id: $user->id,
                name: $user->name.' (@'.$user->username.')',
                image: $user->profile_photo_url,
                options: new SpotlightResultOptions(
                    badgeLabel: $user->getPoints().' XP',
                    badgeColor: 'emerald',
                ),
            ));
    }

    public function execute(Spotlight $spotlight, int|string $user): void
    {
        $model = User::query()->find($user);

        if (! $model) {
            return;
        }

        $spotlight->redirect(route('profile', $model->username), navigate: true);
    }
}
