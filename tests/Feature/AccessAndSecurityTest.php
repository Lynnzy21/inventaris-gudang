<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    // 1. Tamu diarahkan ke login (F-03)
    public function test_guest_is_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    // 2. Staff tidak bisa membuka halaman khusus admin (F-03)
    public function test_staff_cannot_access_admin_product_create()
    {
        $staff = User::create([
            'name' => 'Staff Test',
            'email' => 'stafftest@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        $response = $this->actingAs($staff)->get('/products/create');
        $response->assertStatus(403);
    }

    // 3. Register tidak bisa mengisi role admin (F-01 & Keamanan)
    public function test_register_cannot_set_role_to_admin()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testregister@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'admin', // Percobaan manipulasi role
        ]);

        // Harus berhasil register, tapi role tetap 'staff'
        $this->assertDatabaseHas('users', [
            'email' => 'testregister@example.com',
            'role' => 'staff', 
        ]);
    }

    // 4. Stok keluar melebihi stok tersedia ditolak (BR-03)
    public function test_stock_out_is_rejected_if_insufficient()
    {
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admintest@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

                $category = Category::create(['name' => 'Test Category']);
        
        // Perhatikan: 'stock' TIDAK dimasukkan ke dalam array create (sesuai BR-01)
        $product = Product::create([
            'category_id' => $category->id,
            'sku' => 'TEST-001',
            'name' => 'Test Product',
            'unit' => 'pcs',
            'price' => 10000,
            'min_stock' => 2,
        ]);

        // Set stok secara manual setelah create, karena kolom stock tidak fillable
        $product->stock = 5;
        $product->save();

        $this->actingAs($admin);

        // Coba keluarkan 10, padahal stok hanya 5
        $response = $this->post('/transactions', [
            'product_id' => $product->id,
            'type' => 'out',
            'quantity' => 10, 
            'transaction_date' => now()->toDateString(),
            'note' => 'Test out',
        ]);

        // Harus gagal validasi di controller
        $response->assertSessionHasErrors('quantity');
        
        // Stok di database TIDAK BOLEH berubah
        $this->assertDatabaseHas('products', [
            'id' => $product->id, 
            'stock' => 5
        ]);
    }
}