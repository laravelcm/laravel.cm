<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->string('username')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('bio', 160)->nullable();
            $table->string('location', 50)->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_type')->default('avatar');
            $table->string('phone_number')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 100)->nullable();
            $table->string('github_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->string('website')->nullable();
            $table->boolean('opt_in')->default(false);
            $table->json('settings')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
