<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribes', function (Blueprint $table) {
            $table->uuid('uuid')->index()->unique();
            $table->primary('uuid');
            $table->foreignId('user_id')->index()->constrained();
            $table->morphs('subscribeable');
            $table->unique(['user_id', 'subscribeable_id', 'subscribeable_type'], 'subscribes_are_unique');
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
        Schema::dropIfExists('subscribes');
    }
}
