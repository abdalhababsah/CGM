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
            $table->unsignedBigInteger('delivery_shipment_id')->nullable()->after('delivery_company_id')->comment('Shipment ID from Delivery Service');
            $table->string('delivery_tracking_no', 255)->nullable()->after('delivery_shipment_id')->comment('Tracking Number from Delivery Service');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['delivery_shipment_id', 'delivery_tracking_no']);
        });
    }
};