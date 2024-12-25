<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryLocationAndPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'id' => 1,
                'city_ar' => 'رام الله',
                'city_en' => 'Ramallah',
                'city_he' => 'رام الله',
                'company_city_id' => '1',
                'price' => 10.00, // Adjust price
                'is_active' => true,
            ],
            [
                'id' => 2,
                'city_ar' => 'جنين',
                'city_en' => 'Jenin',
                'city_he' => 'جنין',
                'company_city_id' => '1004',
                'price' => 12.00, 
                'is_active' => true,
            ],
            [
                'id' => 3,
                'city_ar' => 'طوباس',
                'city_en' => 'Tubas',
                'city_he' => 'טובס',
                'company_city_id' => '1005',
                'price' => 12.50, 
                'is_active' => true,
            ],
            [
                'id' => 4,
                'city_ar' => 'طولكرم',
                'city_en' => 'Tulkarm',
                'city_he' => 'טול כרם',
                'company_city_id' => '1006',
                'price' => 13.00,
                'is_active' => true,
            ],
            [
                'id' => 5,
                'city_ar' => 'نابلس',
                'city_en' => 'Nablus',
                'city_he' => 'שכם',
                'company_city_id' => '1007',
                'price' => 14.00, 
                'is_active' => true,
            ],
            [
                'id'=> 6,
                'city_ar' => 'قلقيلية',
                'city_en' => 'Qalqilya',
                'city_he' => 'קלקיליה',
                'company_city_id' => '1008',
                'price' => 10.50, 
                'is_active' => true,
            ],
            [
                'id'=> 7,
                'city_ar' => 'سلفيت',
                'city_en' => 'Salfit',
                'city_he' => 'סלפית',
                'company_city_id' => '1009',
                'price' => 11.00, 
                'is_active' => true,
            ],

            [
                'id'=> 8,
                'city_ar' => 'اريحا',
                'city_en' => 'Jericho',
                'city_he' => 'יריחו',
                'company_city_id' => '1010',
                'price' => 15.00,
                'is_active' => true,
            ],
            [
                'id'=> 9,
                'city_ar' => 'القدس',
                'city_en' => 'Jerusalem',
                'city_he' => 'ירושלים',
                'company_city_id' => '1011',
                'price' => 8.00, 
                'is_active' => true,
            ],
            [
                'id'=> 10,
                'city_ar' => 'بيت لحم',
                'city_en' => 'Bethlehem',
                'city_he' => 'בית לחם',
                'company_city_id' => '1012',
                'price' => 10.00, 
                'is_active' => true,
            ],
            [
                'id'=> 11,
                'city_ar' => 'الخليل',
                'city_en' => 'Hebron',
                'city_he' => 'חברון',
                'company_city_id' => '1013',
                'price' => 9.50, // Adjust price
                'is_active' => true,
            ],
            [
                'id'=> 12,
                'city_ar' => 'مناطق الداخل',
                'city_en' => '48 Area',
                'city_he' => 'פנים 48',
                'company_city_id' => '1014',
                'price' => 20.00, // Adjust price
                'is_active' => true,
            ],
            [
                'id'=> 13,
                'city_ar' => 'ضواحي القدس',
                'city_en' => 'Suburbs of Jerusalem',
                'city_he' => 'פרברי ירושלים',
                'company_city_id' => '1015',
                'price' => 7.00, // Adjust price
                'is_active' => true,
            ],
            [
                'id'=> 14,
                'city_ar' => 'أبو غوش وضواحيها',
                'city_en' => 'Abu Ghoush & Suburbs',
                'city_he' => 'אבו גוש וסביבתה',
                'company_city_id' => '1016',
                'price' => 8.50, // Adjust price
                'is_active' => true,
            ],
            [
                'id'=> 15,
                'city_ar' => 'بيت شمش وضواحيها',
                'city_en' => 'Bet Shemesh & Suburbs',
                'city_he' => 'בית שמש וסביבתה',
                'company_city_id' => '1019',
                'price' => 9.00, // Adjust price
                'is_active' => true,
            ],
            [
                'id'=> 16,
                'city_ar' => 'ايلات /يوم الثلاثاء فقط',
                'city_en' => 'Eilat',
                'city_he' => 'אילת',
                'company_city_id' => '1020',
                'price' => 25.00, // Adjust price
                'is_active' => true,
            ], 
            
            
        ];

        DB::table('delivery_location_and_prices')->insert($locations);
    }
}