<?php

declare(strict_types=1);

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('type')
                ->default(TransactionType::ONETIME->value)
                ->index();
            $table->foreignIdFor(User::class);
            $table->integer('amount');
            $table->integer('fees')->nullable();
            $table->string('transaction_reference');
            $table->string('status')->default(TransactionStatus::PENDING->value);
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
