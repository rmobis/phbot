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

            // I'm not 100% happy with using a "generic" `string` type to also hold `int`s
            // and `timestamps`s, but I'm not sure if there's a better alternative.
            // Could have gone with 3 sets of fields for every type, but that seems too
            // cumbersome; could have gone for a polymorphic relation, but that seems too
            // overengineered; could have gone with putting it all into the payload, but
            // that's just as bad type-safety wise and worse in terms of ease of access.
            // So, yeah, I don't know. Maybe future me will have a better idea
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();

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
