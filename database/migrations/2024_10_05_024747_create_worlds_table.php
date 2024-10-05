<?php

use App\Support\Enum\Region;
use App\Support\Enum\WorldType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worlds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->enum('region', Region::values());
            $table->enum('world_type', WorldType::values());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worlds');
    }
};
