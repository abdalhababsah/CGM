<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryLocationIdToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add delivery_location_id as a foreign key
            $table->foreignId('delivery_location_id')
                  ->nullable()
                  ->constrained('delivery_location_and_prices')
                  ->onDelete('set null')
                  ->after('delivery_company_id'); // Position the column appropriately
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the foreign key and the column
            $table->dropForeign(['delivery_location_id']);
            $table->dropColumn('delivery_location_id');
        });
    }
}