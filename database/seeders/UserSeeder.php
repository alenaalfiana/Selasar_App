<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Selasar',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_as' => 'admin',
            'no_hp' => '081234567890',
        ]);

        User::create([
            'nama' => 'User Selasar',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role_as' => 'user',
            'no_hp' => '081234567891',
        ]);
    }
}