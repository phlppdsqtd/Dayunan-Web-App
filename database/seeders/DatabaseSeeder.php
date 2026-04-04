<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\PackageSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\BookingSeeder;
use Database\Seeders\GallerySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PackageSeeder::class,
            GallerySeeder::class,
            ContactSeeder::class,
            BookingSeeder::class,
        ]);
    }
}