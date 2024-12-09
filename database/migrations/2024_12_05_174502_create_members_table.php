<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->foreignId('member_id')
                ->nullable()
                ->after('guild_rank')
                ->constrained()
                ->nullOnDelete();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->foreignId('main_character_id')
                ->nullable()
                ->constrained('characters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('characters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('member_id');
        });

        Schema::dropIfExists('members');
    }
};
