<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Dayúnan',
            'email' => 'admin@dayunan.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'mobile' => '09171234567',
        ]);

        User::create([
            'name' => 'Guest Dayúnan',
            'email' => 'guest@dayunan.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'mobile' => '09181234567',
        ]);

         User::create([
            'name' => 'Josiah Nalaunan',
            'email' => 'josiah@gmail.com',
            'password' => Hash::make('josiah123'),
            'role' => 'customer',
            'mobile' => '09638808931',
        ]);
    }
}