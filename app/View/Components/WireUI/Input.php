<?php

namespace App\View\Components\WireUI;

use WireUi\View\Components;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class Input extends Components\Input
{
    protected function getDefaultColorClasses(): string
    {
        return Str::of('placeholder-skin-input bg-skin-input text-skin-base')
            ->unless($this->borderless, function (Stringable $stringable) {
                return $stringable
                    ->append(' border border-skin-input focus:ring-flag-green focus:border-flag-green');
            });
    }

    protected function getErrorClasses(): string
    {
        return Str::of('text-negative-900 placeholder-negative-500')
            ->unless($this->borderless, function (Stringable $stringable) {
                return $stringable
                    ->append(' border border-negative-300 focus:ring-negative-500 focus:border-negative-500');
            });
    }

    protected function getDefaultClasses(): string
    {
        return Str::of('block w-full sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none')
            ->unless($this->shadowless, fn (Stringable $stringable) => $stringable->append(' shadow-sm'))
            ->when($this->borderless, function (Stringable $stringable) {
                return $stringable->append(' border-transparent focus:border-transparent focus:ring-transparent');
            });
    }
}
