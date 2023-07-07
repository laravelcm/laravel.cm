<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateReactablesTable extends Migration
{
    public function up(): void
    {
        Schema::create('reactables', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('reaction_id')->constrained();
            $table->morphs('reactable');
            $table->morphs('responder');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reactables');
    }
}
