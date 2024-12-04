<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['articles', 'discussions', 'threads'] as $key => $value) {
            $afterColumn = ($key == 0) ? 'slug' : 'body';
            Schema::table($value, function (Blueprint $table) use ($afterColumn): void {
                $table->string('locale')->default('fr')->after($afterColumn);
            });
        }
    }

    public function down(): void
    {
        foreach (['articles', 'discussions', 'threads'] as $tab) {
            Schema::table($tab, function (Blueprint $table): void {
                $table->dropColumn('locale');
            });
        }
    }
};
