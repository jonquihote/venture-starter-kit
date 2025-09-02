<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::Memberships->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('account_id')
                ->constrained(MigrationsEnum::Accounts->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('team_id')
                ->constrained(MigrationsEnum::Teams->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->json('roles')->nullable();

            $table->unique(['account_id', 'team_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::Memberships->table());
    }
};
