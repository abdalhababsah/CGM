<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_location_and_prices', function (Blueprint $table) {
            $table->id();
            $table->string('city_ar', 255);
            $table->string('city_en', 255);
            $table->string('city_he', 255);
            $table->string('country_en', 255)->default('Unknown');
            $table->string('country_ar', 255)->default('Unknown');
            $table->string('country_he', 255)->default('Unknown');
            $table->decimal('price', 8, 2);
            $table->boolean('is_active')->default(true); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_location_and_prices');
    }
};