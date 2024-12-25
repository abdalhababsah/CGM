<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_location_id') // Foreign key to cities
                  ->constrained('delivery_location_and_prices')
                  ->onDelete('cascade'); // If a city is deleted, its areas are deleted too
            $table->string('area_en', 255);
            $table->string('area_ar', 255);
            $table->string('area_he', 255)->nullable(); // Optional Hebrew name
            $table->string('company_area_id', 255)->nullable(); // For delivery company integration
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
}