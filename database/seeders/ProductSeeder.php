<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user admin sebagai pencatat transaksi awal.
        $admin = User::where('email', 'admin@example.com')->first();

        // Ambil kategori berdasarkan nama supaya tidak bergantung urutan id.
        $elektronik      = Category::where('name', 'Elektronik')->first();
        $alatTulis       = Category::where('name', 'Alat Tulis')->first();
        $rumahTangga     = Category::where('name', 'Rumah Tangga')->first();
        $makananMinuman  = Category::where('name', 'Makanan Minuman')->first();
        $perkakas        = Category::where('name', 'Perkakas')->first();

        // 15 produk, 3 per kategori. Stok awal dibuat 0, lalu ditambah lewat
        // transaksi masuk supaya BR-02 terpenuhi sejak awal.
        $products = [
            // Elektronik
            ['category_id' => $elektronik->id, 'sku' => 'ELK-001', 'name' => 'Kabel HDMI 2m',       'unit' => 'pcs', 'price' => 45000,  'stock' => 25,  'min_stock' => 5],
            ['category_id' => $elektronik->id, 'sku' => 'ELK-002', 'name' => 'Mouse Wireless',      'unit' => 'pcs', 'price' => 85000,  'stock' => 12,  'min_stock' => 5],
            ['category_id' => $elektronik->id, 'sku' => 'ELK-003', 'name' => 'Flashdisk 32GB',      'unit' => 'pcs', 'price' => 75000,  'stock' => 3,   'min_stock' => 5],

            // Alat Tulis
            ['category_id' => $alatTulis->id, 'sku' => 'ATK-001', 'name' => 'Pulpen Hitam',         'unit' => 'lusin', 'price' => 36000, 'stock' => 40, 'min_stock' => 10],
            ['category_id' => $alatTulis->id, 'sku' => 'ATK-002', 'name' => 'Buku Tulis A5',        'unit' => 'pcs', 'price' => 5000,  'stock' => 8,   'min_stock' => 10],
            ['category_id' => $alatTulis->id, 'sku' => 'ATK-003', 'name' => 'Penghapus Staedtler',  'unit' => 'pcs', 'price' => 3500,  'stock' => 60,  'min_stock' => 15],

            // Rumah Tangga
            ['category_id' => $rumahTangga->id, 'sku' => 'RTG-001', 'name' => 'Sabun Cuci Piring',  'unit' => 'botol', 'price' => 18000, 'stock' => 20, 'min_stock' => 5],
            ['category_id' => $rumahTangga->id, 'sku' => 'RTG-002', 'name' => 'Tisu Gulung',        'unit' => 'pack', 'price' => 25000, 'stock' => 4,  'min_stock' => 5],
            ['category_id' => $rumahTangga->id, 'sku' => 'RTG-003', 'name' => 'Deterjen Bubuk 1kg', 'unit' => 'pcs', 'price' => 22000, 'stock' => 30, 'min_stock' => 8],

            // Makanan Minuman
            ['category_id' => $makananMinuman->id, 'sku' => 'MNM-001', 'name' => 'Kopi Sachet',     'unit' => 'pcs', 'price' => 2000, 'stock' => 100, 'min_stock' => 20],
            ['category_id' => $makananMinuman->id, 'sku' => 'MNM-002', 'name' => 'Teh Celup',       'unit' => 'box', 'price' => 12000, 'stock' => 2, 'min_stock' => 5],
            ['category_id' => $makananMinuman->id, 'sku' => 'MNM-003', 'name' => 'Air Mineral 600ml', 'unit' => 'dus', 'price' => 55000, 'stock' => 15, 'min_stock' => 5],

            // Perkakas
            ['category_id' => $perkakas->id, 'sku' => 'PRK-001', 'name' => 'Obeng Plus Set',        'unit' => 'set', 'price' => 65000, 'stock' => 7,  'min_stock' => 3],
            ['category_id' => $perkakas->id, 'sku' => 'PRK-002', 'name' => 'Tang Kombinasi',        'unit' => 'pcs', 'price' => 48000, 'stock' => 5,  'min_stock' => 3],
            ['category_id' => $perkakas->id, 'sku' => 'PRK-003', 'name' => 'Meteran 5m',            'unit' => 'pcs', 'price' => 32000, 'stock' => 0,  'min_stock' => 3],
        ];

        foreach ($products as $data) {
            $targetStock = $data['stock'];
            unset($data['stock']); // stok tidak diisi langsung

            // Buat produk dengan stok awal 0.
            $product = Product::create(array_merge($data, ['stock' => 0]));

            // Buat transaksi masuk awal supaya BR-02 terpenuhi:
            // stock = sum(transaksi masuk) - sum(transaksi keluar).
            if ($targetStock > 0) {
                StockTransaction::create([
                    'product_id'       => $product->id,
                    'user_id'          => $admin->id,
                    'type'             => 'in',
                    'quantity'         => $targetStock,
                    'note'             => 'Stok awal dari seeder',
                    'transaction_date' => now()->toDateString(),
                ]);

                // Sinkronkan kolom stock di tabel products.
                $product->stock = $targetStock;
                $product->save();
            }
        }
    }
}