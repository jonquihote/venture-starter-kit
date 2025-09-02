<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(MigrationsEnum::Accounts->table(), function (Blueprint $table): void {
            $table->foreignId('current_team_id')
                ->nullable()
                ->constrained(MigrationsEnum::Teams->table())
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table(MigrationsEnum::Accounts->table(), function (Blueprint $table): void {
            $table->dropForeign(['current_team_id']);
            $table->dropColumn('current_team_id');
        });
    }
};
