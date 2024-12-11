<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishListItemsTable extends Migration
{
    public function up()
    {
        Schema::create('wish_list_items', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('wish_list_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at

            // Unique Index to prevent duplicate products in the same wish list
            $table->unique(['wish_list_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wish_list_items');
    }
}
