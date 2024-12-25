<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('social_accounts', static function (Blueprint $table): void {
            $table->text('avatar')->nullable()->change(); // Text because Github avatar can be greater than 255 characters
        });
    }
};
