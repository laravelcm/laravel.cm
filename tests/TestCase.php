<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use CreatesUsers;

    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('config:clear');
    }
}
