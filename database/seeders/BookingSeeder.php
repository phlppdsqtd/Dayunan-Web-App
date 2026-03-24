<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. A pending booking for a Small Gathering (22 Hours)
        Booking::create([
            'user_id' => 2, 
            'package_id' => 1, 
            'check_in' => Carbon::now()->addDays(10)->toDateString(),
            'check_out' => Carbon::now()->addDays(11)->toDateString(),
            'status' => 'pending',
            'total_price' => 16000.00,
        ]);

        // 2. An approved booking for a Large Event (12 Hours)
        Booking::create([
            'user_id' => 2, 
            'package_id' => 4, 
            'check_in' => Carbon::now()->addDays(20)->toDateString(),
            'check_out' => Carbon::now()->addDays(20)->toDateString(),
            'status' => 'approved',
            'total_price' => 21000.00,
        ]);

        // 3. A past/completed booking for a Large Event with Sound/Lights (22 Hours)
        Booking::create([
            'user_id' => 2, 
            'package_id' => 5, 
            'check_in' => Carbon::now()->subDays(5)->toDateString(),
            'check_out' => Carbon::now()->subDays(4)->toDateString(),
            'status' => 'approved',
            'total_price' => 37000.00,
        ]);

        Booking::create([
            'user_id' => 3, 
            'package_id' => 6, 
            'check_in' => Carbon::now()->subDays(5)->toDateString(),
            'check_out' => Carbon::now()->subDays(4)->toDateString(),
            'status' => 'approved',
            'total_price' => 20000.00,
        ]);


        
    }
}