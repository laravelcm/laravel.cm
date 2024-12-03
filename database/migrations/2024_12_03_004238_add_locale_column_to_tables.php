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
        Schema::table('articles', function (Blueprint $table): void {
            $table->string('locale')->default('fr')->after('slug');
        });

        Schema::table('discussions', function (Blueprint $table): void {
            $table->string('locale')->default('fr')->after('body');
        });

        Schema::table('threads', function (Blueprint $table): void {
            $table->string('locale')->default('fr')->after('body');
        });
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
