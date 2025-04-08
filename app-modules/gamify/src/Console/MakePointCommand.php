<?php

declare(strict_types=1);

namespace Laravelcm\Badges\Console;

use Illuminate\Console\GeneratorCommand;

final class MakePointCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected string $signature = 'gamify:point {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Create a Gamify point type class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $type = 'Point';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__.'/stubs/point.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace  The root namespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Gamify\Points';
    }
}
