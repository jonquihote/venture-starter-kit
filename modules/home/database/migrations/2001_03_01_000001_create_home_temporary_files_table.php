<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Home\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::TEMPORARY_FILES->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->integer('downloads_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::TEMPORARY_FILES->table());
    }
};
