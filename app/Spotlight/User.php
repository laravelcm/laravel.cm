<?php

namespace App\Spotlight;

use App\Models\User as UserModel;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use LivewireUI\Spotlight\SpotlightSearchResult;

class User extends SpotlightCommand
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

    public function searchUser($query)
    {
        return UserModel::where('name', 'like', "%$query%")
            ->orWhere('username', 'like', "%$query%")
            ->get()
            ->map(function (UserModel $user) {
                return new SpotlightSearchResult(
                    $user->id,
                    $user->name,
                    sprintf('profile de @%s', $user->username)
                );
            });
    }

    public function execute(Spotlight $spotlight, UserModel $user)
    {
        $spotlight->redirect('/user/' . $user->username);
    }
}
