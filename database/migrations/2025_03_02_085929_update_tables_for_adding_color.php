<?php

use App\Models\ProductColor;
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
        Schema::table('order_items', function (Blueprint $table) {
            $table->after('product_id', function ($table) {
                $table->string('hex', 10)->nullable();
            });
        });
        Schema::table('cart_items', function (Blueprint $table) {
            $table->after('product_id', function ($table) {
                $table->foreignIdFor(ProductColor::class)->nullable()->constrained()->nullOnDelete();
            });
            $table->unique(['cart_id', 'product_id', 'product_color_id']);
            $table->dropUnique('cart_items_cart_id_product_id_unique');
        });
    }

};
