<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('guilds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->unique();
            $table->text('description');
            $table->string('logo', 128);
            $table->foreignId('world_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('guilds');
    }
};
