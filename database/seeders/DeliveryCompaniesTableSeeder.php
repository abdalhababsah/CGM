<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryCompany;

class DeliveryCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryCompany::create([
            'name' => 'DHL',
            'contact_info' => 'contact@dhl.com',
            'is_active' => true,
        ]);

        DeliveryCompany::create([
            'name' => 'FedEx',
            'contact_info' => 'support@fedex.com',
            'is_active' => true,
        ]);

        // Add more delivery companies as needed
    }
}
