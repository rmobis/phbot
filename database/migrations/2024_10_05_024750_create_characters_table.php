<?php

use App\Support\Enum\Vocation;
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
            $table->string('name', 128);
            $table->integer('level');
            $table->enum('vocation', Vocation::values());
            $table->foreignId('world_id')->constrained();
            $table->foreignId('guild_id')->nullable()->constrained();
            $table->foreignId('member_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
