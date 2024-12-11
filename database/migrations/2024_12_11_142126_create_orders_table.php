<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('discount_code_id')->nullable()->constrained('discount_codes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Null for guest checkouts
            $table->foreignId('delivery_company_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method', 50)->default('Cash on Delivery');
            $table->string('status', 50)->default('Pending');
            $table->string('preferred_language', 5)->default('en')->comment('e.g., en, ar, he'); // Language for order communications
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
