<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) { // Use 'order_histories' instead of 'order_history'
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('status', 50); 
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('order_histories'); 
    }
}
