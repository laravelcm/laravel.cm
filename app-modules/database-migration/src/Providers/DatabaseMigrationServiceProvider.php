<?php

declare(strict_types=1);

namespace Laravelcm\DatabaseMigration\Providers;

use Illuminate\Support\ServiceProvider;
use Laravelcm\DatabaseMigration\Commands\MigrateDatabaseCommand;
use Laravelcm\DatabaseMigration\Commands\MigrateFilesToS3Command;
use Laravelcm\DatabaseMigration\Commands\ResetPostgresSequencesCommand;
use Laravelcm\DatabaseMigration\Commands\SshTunnelCommand;
use Laravelcm\DatabaseMigration\Services\DatabaseMigrationService;
use Laravelcm\DatabaseMigration\Services\SshTunnelService;

final class DatabaseMigrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/ssh-tunnel.php',
            'ssh-tunnel'
        );

        $this->app->singleton(SshTunnelService::class);
        $this->app->singleton(DatabaseMigrationService::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SshTunnelCommand::class,
                MigrateDatabaseCommand::class,
                MigrateFilesToS3Command::class,
                ResetPostgresSequencesCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../../config/ssh-tunnel.php' => config_path('ssh-tunnel.php'),
            ], 'ssh-tunnel-config');
        }

        // Auto-activate tunnel if configured
        if (config('ssh-tunnel.auto_activate', false)) {
            $this->app->booted(function (): void {
                try {
                    $this->app->make(SshTunnelService::class)->activate();
                } catch (\Exception $e) {
                    // Log error but don't break the application
                    logger()->error('Failed to auto-activate SSH tunnel: '.$e->getMessage());
                }
            });
        }
    }
}
