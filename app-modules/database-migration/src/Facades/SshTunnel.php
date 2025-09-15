<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Facades;

use Illuminate\Support\Facades\Facade;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

/**
 * @method static int activate()
 * @method static bool isActive()
 * @method static bool destroy()
 */
final class SshTunnel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return SshTunnelService::class;
    }
}
