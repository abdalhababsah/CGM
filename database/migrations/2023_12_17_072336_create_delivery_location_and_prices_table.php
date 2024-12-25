<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryLocationAndPricesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('delivery_location_and_prices', function (Blueprint $table) {
            $table->id();
            $table->string('city_ar', 255);
            $table->string('city_en', 255);
            $table->string('city_he', 255);
            $table->string('company_city_id', 255)->nullable(); // For delivery company integration
            $table->decimal('price', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_location_and_prices');
    }
}