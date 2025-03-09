<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', static function (Blueprint $table): void {
            $table->longText('reason')->nullable()->after('canonical_url');
        });
    }
};
