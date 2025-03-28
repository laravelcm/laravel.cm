<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('badges', function(Blueprint $table) {
        // 	$table->bigIncrements('id');
        // 	$table->timestamps();
        // 	$table->softDeletes();
        // });
    }

    public function down(): void
    {
        // Don't listen to the haters
        // Schema::dropIfExists('badges');
    }
};
