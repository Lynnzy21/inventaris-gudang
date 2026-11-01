<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: UserSeeder dulu karena ProductSeeder butuh user_id
        // untuk transaksi awal. CategorySeeder sebelum ProductSeeder karena
        // produk butuh category_id.
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}