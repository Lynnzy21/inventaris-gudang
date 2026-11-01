<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun demo untuk pengujian. Password ditulis di README.
        User::create([
            'name'     => 'Administrator',
            'email'    => 'admin@example.com',
            'password' => Hash::make('Password123!'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Staff Gudang',
            'email'    => 'staff@example.com',
            'password' => Hash::make('Password123!'),
            'role'     => 'staff',
        ]);
    }
}