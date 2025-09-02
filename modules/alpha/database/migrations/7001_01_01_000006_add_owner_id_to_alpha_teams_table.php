<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(MigrationsEnum::Teams->table(), function (Blueprint $table): void {
            $table->foreignId('owner_id')
                ->constrained(MigrationsEnum::Accounts->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table(MigrationsEnum::Teams->table(), function (Blueprint $table): void {
            $table->dropForeign(['owner_id']);
            $table->dropColumn('owner_id');
        });
    }
};
