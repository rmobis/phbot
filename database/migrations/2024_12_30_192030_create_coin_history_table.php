<?php

use App\Support\Enums\CoinHistoryEntryType;
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
        Schema::create('coin_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entry_number');
            $table->timestamp('happened_at');
            $table->string('description');
            $table->string('character')->nullable();
            $table->integer('balance');

            $table->enum('type', CoinHistoryEntryType::values());
            $table->foreignId('origin_character_id')->nullable()->constrained('characters')->nullOnDelete();
            $table->foreignId('destination_character_id')->nullable()->constrained('characters')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_history');
    }
};
