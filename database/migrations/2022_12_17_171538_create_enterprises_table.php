<?php

declare(strict_types=1);

use App\Enums\EnterpriseSize;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('enterprises', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('website')->unique();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->longText('about')->nullable();
            $table->year('founded_in')->nullable();
            $table->string('ceo')->nullable();
            $table->foreignIdFor(User::class);
            $table->boolean('is_certified')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_public')->default(true);
            $table->string('size')->default(EnterpriseSize::SEED->value);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::create('enterprise_has_relations', function (Blueprint $table): void {
            $table->unsignedBigInteger('enterprise_id')->index();
            $table->foreign('enterprise_id')
                ->references('id')
                ->on('enterprises')
                ->onDelete('CASCADE');
            $table->morphs('model');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enterprise_has_relations');
        Schema::dropIfExists('enterprises');
    }
};
