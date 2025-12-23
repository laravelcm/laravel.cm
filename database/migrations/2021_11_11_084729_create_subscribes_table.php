<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscribes', static function (Blueprint $table): void {
            $table->uuid()->primary();
            $table->foreignId('user_id')->index()->constrained();

            $table->morphs('subscribeable');
            $table->unique(['user_id', 'subscribeable_id', 'subscribeable_type'], 'subscribes_are_unique');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribes');
    }
};
