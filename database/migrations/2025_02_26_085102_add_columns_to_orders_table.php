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
        Schema::table('orders', function (Blueprint $table) {
            $table->after('total_amount', function ($table) {
                $table->double('discount')->default(0);
                $table->double('finalPrice')->default(0);
            });
        });
    }
};
