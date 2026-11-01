<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik',      'description' => 'Perangkat dan komponen elektronik'],
            ['name' => 'Alat Tulis',      'description' => 'Perlengkapan kantor dan sekolah'],
            ['name' => 'Rumah Tangga',    'description' => 'Barang keperluan rumah tangga'],
            ['name' => 'Makanan Minuman', 'description' => 'Konsumsi dan minuman kemasan'],
            ['name' => 'Perkakas',        'description' => 'Alat kerja dan perkakas bengkel'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}