<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tags', static function (Blueprint $table): void {
            $table->jsonb('concerns')->change();
        });

        Schema::table('channels', static function (Blueprint $table): void {
            $table->jsonb('description')->nullable()->change();
        });

        Schema::table('users', static function (Blueprint $table): void {
            $table->jsonb('settings')->nullable()->change();
        });

        Schema::table('plans', static function (Blueprint $table): void {
            $table->jsonb('name')->change();
            $table->jsonb('description')->nullable()->change();
        });

        Schema::table('enterprises', static function (Blueprint $table): void {
            $table->jsonb('settings')->nullable()->change();
        });

        Schema::table('activities', static function (Blueprint $table): void {
            $table->jsonb('data')->nullable()->change();
        });

        Schema::table('transactions', static function (Blueprint $table): void {
            $table->jsonb('metadata')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tags', static function (Blueprint $table): void {
            $table->json('concerns')->change();
        });

        Schema::table('channels', static function (Blueprint $table): void {
            $table->json('description')->nullable()->change();
        });

        Schema::table('users', static function (Blueprint $table): void {
            $table->json('settings')->nullable()->change();
        });

        Schema::table('plans', static function (Blueprint $table): void {
            $table->json('name')->change();
            $table->json('description')->nullable()->change();
        });

        Schema::table('enterprises', static function (Blueprint $table): void {
            $table->json('settings')->nullable()->change();
        });

        Schema::table('activities', static function (Blueprint $table): void {
            $table->json('data')->nullable()->change();
        });

        Schema::table('transactions', static function (Blueprint $table): void {
            $table->json('metadata')->nullable()->change();
        });
    }
};
