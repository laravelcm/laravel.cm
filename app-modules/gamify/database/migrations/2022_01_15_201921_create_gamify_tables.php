<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateGamifyTables extends Migration
{
    public function up(): void
    {
        Schema::create('reputations', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->mediumInteger('point', false)->default(0);
            $table->bigInteger('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('payee_id')->nullable();
            $table->text('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reputations');
    }
}
