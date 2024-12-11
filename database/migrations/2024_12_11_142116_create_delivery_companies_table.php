<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create('delivery_companies', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255);
            $table->string('contact_info', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_companies');
    }
}
