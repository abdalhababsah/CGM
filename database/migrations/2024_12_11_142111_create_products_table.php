<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('sku', 100)->unique();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->string('name_en', 255);
            $table->string('name_ar', 255);
            $table->string('name_he', 255);
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_he')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
