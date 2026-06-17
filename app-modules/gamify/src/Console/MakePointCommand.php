<?php

declare(strict_types=1);

namespace Laravelcm\Gamify\Console;

use Illuminate\Console\GeneratorCommand;

#[\Illuminate\Console\Attributes\Description('Create a Gamify point type class.')]
#[\Illuminate\Console\Attributes\Signature('gamify:point {name}')]
final class MakePointCommand extends GeneratorCommand
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Point';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/point.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace  The root namespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Gamify\Points';
    }
}
