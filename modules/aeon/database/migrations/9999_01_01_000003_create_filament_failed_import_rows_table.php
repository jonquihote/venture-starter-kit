<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filament_failed_import_rows', function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('import_id')
                ->constrained('filament_imports')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->json('data');
            $table->text('validation_error')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failed_import_rows');
    }
};
