<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Omega\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::Invitations->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::Invitations->table());
    }
};
