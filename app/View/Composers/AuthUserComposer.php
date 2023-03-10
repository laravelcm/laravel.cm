<?php

namespace App\View\Composers;

use Illuminate\View\View;

final class AuthUserComposer
{
    public function compose(View $view): void
    {
        if (auth()->check()) {
            $view->with('authenticate', auth()->user());
        } else {
            $view->with('authenticate', null);
        }
    }
}
