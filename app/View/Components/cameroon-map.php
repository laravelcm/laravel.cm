<?php

declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class cameroon-map extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View
    {
        return view('components.cameroon-map');
    }
}
