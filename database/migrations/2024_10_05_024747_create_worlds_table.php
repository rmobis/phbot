<?php

use App\Support\Enums\Region;
use App\Support\Enums\WorldType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worlds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->unique();
            $table->enum('region', Region::values());
            $table->enum('type', WorldType::values());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worlds');
    }
};
