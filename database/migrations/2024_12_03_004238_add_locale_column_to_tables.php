<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['articles', 'discussions', 'threads'];

    public function up(): void
    {
        foreach ($this->tables as $tab) {
            Schema::table($tab, function (Blueprint $table): void {
                $table->string('locale')->default('fr');
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $tab) {
            Schema::table($tab, function (Blueprint $table): void {
                $table->dropColumn('locale');
            });
        }
    }
};
