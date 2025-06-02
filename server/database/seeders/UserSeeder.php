<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@possibilitea.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Manager User',
            'email' => 'manager@possibilitea.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@possibilitea.com',
            'password' => Hash::make('password123'),
            'role' => 'cashier',
        ]);
    }
}