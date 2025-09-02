<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Home\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::Subscriptions->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('team_id')
                ->constrained(MigrationsEnum::Teams->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('application_id')
                ->constrained(MigrationsEnum::Applications->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique(['team_id', 'application_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::Subscriptions->table());
    }
};
