<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

final class CreatePlanSubscriptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create(config('rinvex.subscriptions.tables.plan_subscriptions'), function (Blueprint $table): void {
            $table->increments('id');
            $table->morphs('subscriber');
            $table->integer('plan_id')->unsigned();
            $table->string('slug');
            $table->json('name');
            $table->json('description')->nullable();
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
            $table->dateTime('cancels_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique('slug');
            $table->foreign('plan_id')->references('id')->on(config('rinvex.subscriptions.tables.plans'))
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('rinvex.subscriptions.tables.plan_subscriptions'));
    }
}
