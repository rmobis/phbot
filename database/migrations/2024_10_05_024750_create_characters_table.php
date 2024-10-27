<?php

use App\Support\Enums\Vocation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->unique();
            $table->integer('level');
            $table->enum('vocation', Vocation::values());
            $table->foreignId('world_id')->constrained();
            $table->foreignId('guild_id')->nullable()->constrained()->nullOnDelete();
            $table->string('guild_rank', 128)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
