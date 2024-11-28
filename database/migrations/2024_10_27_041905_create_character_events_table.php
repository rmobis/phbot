<?php

use App\Support\Enums\CharacterEventType;
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
        Schema::disableForeignKeyConstraints();

        Schema::create('character_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->timestamp('happened_at');
            $table->enum('type', CharacterEventType::values());

            $table->string('old_value_str')->nullable();
            $table->string('new_value_str')->nullable();

            $table->integer('old_value_int')->nullable();
            $table->integer('new_value_int')->nullable();

            $table->timestamp('old_value_ts')->nullable();
            $table->timestamp('new_value_ts')->nullable();

            $table->json('payload')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_events');
    }
};
