<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('channels', static function (Blueprint $table): void {
            $table->id();
            $table->uuid('public_id');
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('channels')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};
