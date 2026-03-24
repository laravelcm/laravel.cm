<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('content_issues', static function (Blueprint $table): void {
            $table->id();
            $table->morphs('issueable');
            $table->string('type');
            $table->string('status')->default('detected');
            $table->jsonb('details')->nullable();

            $table->timestamp('detected_at');
            $table->timestamp('notified_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'deadline_at']);
            $table->index(['issueable_type', 'issueable_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_issues');
    }
};
