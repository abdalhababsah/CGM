<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id(); 
            $table->string('code', 50)->unique(); // Unique discount code
            $table->enum('type', ['fixed', 'percentage']); // Type of discount
            $table->decimal('amount', 8, 2); // Discount amount
            $table->integer('usage_limit')->nullable(); // Max usage
            $table->integer('times_used')->default(0); // Times used
            $table->date('expiry_date')->nullable(); // Expiry date
            $table->boolean('is_active')->default(true); // Active status
            $table->softDeletes();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
}