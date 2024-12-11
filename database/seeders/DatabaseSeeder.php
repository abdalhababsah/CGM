<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            BrandsTableSeeder::class,
            ProductsTableSeeder::class,
            ProductImagesTableSeeder::class,
            DeliveryCompaniesTableSeeder::class,
            OrdersTableSeeder::class,
            OrderItemsTableSeeder::class,
            CartsTableSeeder::class,
            CartItemsTableSeeder::class,
            WishListsTableSeeder::class,
            WishListItemsTableSeeder::class,
            NotificationsTableSeeder::class,
            OrderHistoryTableSeeder::class,
            OrderLocationsTableSeeder::class,
        ]);
    }
}
