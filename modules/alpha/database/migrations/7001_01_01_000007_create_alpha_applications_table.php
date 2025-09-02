<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::Applications->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('slug');
            $table->string('icon');
            $table->string('page');

            $table->boolean('is_subscribed_by_default');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::Applications->table());
    }
};
