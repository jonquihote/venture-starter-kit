<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Venture\Alpha\Enums\MigrationsEnum;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(MigrationsEnum::Attachments->table(), function (Blueprint $table): void {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('downloads_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(MigrationsEnum::Attachments->table());
    }
};
