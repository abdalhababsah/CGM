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
        Schema::create('hair_pores', function (Blueprint $table) {
            $table->id();
            $table->string('name_en', 255); // English name
            $table->string('name_ar', 255); // Arabic name
            $table->string('name_he', 255); // Hebrew name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hair_pores');
    }
};
