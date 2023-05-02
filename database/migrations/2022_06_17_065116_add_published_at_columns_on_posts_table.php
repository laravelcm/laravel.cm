<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->after('user_id', function ($table) {
                $table->timestamp('published_at')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->removeColumn('published_at');
        });
    }
};
