<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum as AlphaMigrationsEnum;
use Venture\Omega\Enums\MigrationsEnum as OmegaMigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(OmegaMigrationsEnum::Invitations->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('team_id')
                ->constrained(AlphaMigrationsEnum::Teams->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(OmegaMigrationsEnum::Invitations->table());
    }
};
