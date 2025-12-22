<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class AppLayout extends BaseLayout
{
    public function render(): View
    {
        return view('layouts.app');
    }
}
