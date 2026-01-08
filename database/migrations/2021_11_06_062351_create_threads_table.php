<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('threads', static function (Blueprint $table): void {
            $table->id();
            $table->uuid('public_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('solution_reply_id')->index()->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->boolean('locked')->default(false);

            $table->timestamp('last_posted_at')->useCurrent();
            $table->timestamps();
        });

        Schema::create('channel_thread', static function (Blueprint $table): void {
            $table->foreignId('channel_id')->constrained();
            $table->foreignId('thread_id')->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channel_thread');
        Schema::dropIfExists('threads');
    }
};
