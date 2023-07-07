<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

final class CreateViewsTable extends Migration
{
    /**
     * The database schema.
     *
     * @var \Illuminate\Support\Facades\Schema
     */
    protected $schema;

    /**
     * The table name.
     *
     * @var string
     */
    protected string $table;

    public function __construct()
    {
        $this->schema = Schema::connection(
            config('eloquent-viewable.models.view.connection')
        );

        $this->table = config('eloquent-viewable.models.view.table_name');
    }

    public function up(): void
    {
        $this->schema->create($this->table, function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->morphs('viewable');
            $table->text('visitor')->nullable();
            $table->string('collection')->nullable();
            $table->timestamp('viewed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
}
