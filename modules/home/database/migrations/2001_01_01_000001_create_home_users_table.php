<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Home\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::USERS->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('password');
            $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::USERS->table());
    }
};
