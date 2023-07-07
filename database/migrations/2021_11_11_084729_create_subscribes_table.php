<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateSubscribesTable extends Migration
{
    public function up(): void
    {
        Schema::create('subscribes', function (Blueprint $table): void {
            $table->uuid('uuid')->index()->unique();
            $table->primary('uuid');
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
}
