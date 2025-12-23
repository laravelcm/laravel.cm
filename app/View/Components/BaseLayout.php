<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseLayout extends Component
{
    public function __construct(
        public ?string $title,
        public ?string $canonical
    ) {}

    public function render(): View
    {
        return view('layouts.base');
    }
}
