<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Home\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::USER_CREDENTIALS->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained(MigrationsEnum::USERS->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('type');
            $table->string('value')->unique();

            $table->boolean('is_primary');

            $table->timestamp('verified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::USER_CREDENTIALS->table());
    }
};
