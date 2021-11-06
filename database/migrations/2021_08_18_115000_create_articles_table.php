<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->string('slug')->unique();
            $table->string('canonical_url')->nullable();
            $table->boolean('show_toc')->default(false);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_sponsored')->default(false);
            $table->unsignedBigInteger('tweet_id')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('shared_at')->nullable();
            $table->timestamp('declined_at')->nullable();
            $table->timestamp('sponsored_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
