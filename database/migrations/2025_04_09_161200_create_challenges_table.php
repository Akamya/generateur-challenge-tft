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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tft_users')->onDelete('cascade');
            $table->foreignId('season_id')->constrained('tft_seasons')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('tft_positions')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('tft_formations')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('tft_classes')->onDelete('cascade');
            $table->foreignId('origin_id')->constrained('tft_origins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};
