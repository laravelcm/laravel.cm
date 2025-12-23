<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

final class CreateSshTunnel implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function handle(SshTunnelService $tunnelService): int
    {
        return $tunnelService->activate();
    }
}
