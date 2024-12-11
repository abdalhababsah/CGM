<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderLocationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Links to orders table
            $table->string('status', 50)->default('In Transit'); // Status of the order at this location
            $table->string('latitude')->nullable(); // Latitude coordinate
            $table->string('longitude')->nullable(); // Longitude coordinate
            $table->string('city')->nullable(); // City name
            $table->string('state')->nullable(); // State or region
            $table->string('country')->nullable(); // Country
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_locations');
    }
}
