<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\App;

abstract class TestCase extends BaseTestCase
{
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();

        App::setLocale('fr');
    }
}
