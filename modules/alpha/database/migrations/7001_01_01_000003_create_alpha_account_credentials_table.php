<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::AccountCredentials->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->foreignId('account_id')
                ->constrained(MigrationsEnum::Accounts->table())
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('type');
            $table->string('value')->unique();
            $table->timestamp('verified_at')->nullable();

            $table->boolean('is_primary');

            $table->unique(['account_id', 'type', 'is_primary']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::AccountCredentials->table());
    }
};
