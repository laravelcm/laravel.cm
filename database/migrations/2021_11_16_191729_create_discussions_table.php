<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discussions', static function (Blueprint $table): void {
            $table->id();
            $table->uuid('public_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('locked')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
