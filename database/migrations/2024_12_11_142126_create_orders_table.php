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
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId(column: 'delivery_company_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId(column: 'area_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('total_amount', 10, 2);
            $table->string('delivery_shipment_id')->nullable()->comment('ID provided by the delivery service');
            $table->string('delivery_tracking_no')->nullable()->comment('Tracking number for the delivery shipment');    
            $table->string('payment_method', 50)->default('Cash on Delivery');
            $table->string('note')->nullable();
            $table->string('phone2')->nullable();
            $table->enum('status', ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled', 'Returned', 'Submitted'])->default('Pending');
            $table->string('preferred_language', 5)->default('en')->comment('e.g., en, ar, he');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
