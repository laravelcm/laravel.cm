<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(config('mails.database.tables.events', 'mail_events'), static function (Blueprint $table): void {
            $table->timestamp('unsuppressed_at')
                ->nullable()
                ->after('occurred_at');
        });

        Schema::table(config('mails.database.tables.mails', 'mails'), static function (Blueprint $table): void {
            $table->string('mailer')
                ->after('uuid');

            $table->string('stream_id')
                ->nullable()
                ->after('mailer');
        });
    }
};
