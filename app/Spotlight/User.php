<?php

declare(strict_types=1);

namespace App\Spotlight;

use App\Models\User as UserModel;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

final class User extends SpotlightCommand
{
    protected string $name = 'User';

    protected string $description = 'rechercher un utilisateur spécifique';

    protected array $synonyms = [];

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                SpotlightCommandDependency::make('user')
                    ->setPlaceholder('Rechercher un utilisateur spécifique')
            );
    }

    public function searchUser(string $query): Collection
    {
        return UserModel::where('name', 'like', "%{$query}%")
            ->orWhere('username', 'like', "%{$query}%")
            ->get()
            ->map(fn (UserModel $user) => new SpotlightSearchResult(
                $user->id,
                $user->name,
                sprintf('profile de @%s', $user->username)
            ));
    }

    public function execute(Spotlight $spotlight, UserModel $user): void
    {
        $spotlight->redirect('/user/'.$user->username);
    }
}
