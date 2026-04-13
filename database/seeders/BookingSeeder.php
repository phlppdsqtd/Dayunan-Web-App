<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Package; // Make sure we import the Package model
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
        $checkIn1 = Carbon::now()->addDays(10);
        $checkOut1 = Carbon::now()->addDays(11);
        Booking::create([
            'user_id' => 2, 
            'package_id' => 1, 
            'check_in' => $checkIn1->toDateString(),
            'check_out' => $checkOut1->toDateString(),
            'status' => 'pending',
            'total_price' => $this->calculatePrice(1, $checkIn1, $checkOut1),
        ]);

        // 2. An approved booking for a Large Event (12 Hours)
        $checkIn2 = Carbon::now()->addDays(20);
        $checkOut2 = Carbon::now()->addDays(21);
        Booking::create([
            'user_id' => 2, 
            'package_id' => 4, 
            'check_in' => $checkIn2->toDateString(),
            'check_out' => $checkOut2->toDateString(),
            'status' => 'approved',
            'total_price' => $this->calculatePrice(4, $checkIn2, $checkOut2),
        ]);

        // 3. A past/completed booking for a Large Event with Sound/Lights (22 Hours)
        $checkIn3 = Carbon::now()->subDays(5);
        $checkOut3 = Carbon::now()->subDays(4);
        Booking::create([
            'user_id' => 2, 
            'package_id' => 5, 
            'check_in' => $checkIn3->toDateString(),
            'check_out' => $checkOut3->toDateString(),
            'status' => 'approved',
            'total_price' => $this->calculatePrice(5, $checkIn3, $checkOut3),
        ]);

        // 4. josiah sample 1
        $checkIn4 = Carbon::now()->addDays(12);
        $checkOut4 = Carbon::now()->addDays(13);
        Booking::create([
            'user_id' => 3, 
            'package_id' => 4, 
            'check_in' => $checkIn4->toDateString(),
            'check_out' => $checkOut4->toDateString(),
            'status' => 'approved',
            'total_price' => $this->calculatePrice(4, $checkIn4, $checkOut4),
        ]);

        // 5. josiah sample 2
        $checkIn5 = Carbon::now()->addDays(5);
        $checkOut5 = Carbon::now()->addDays(7);
        Booking::create([
            'user_id' => 3, 
            'package_id' => 1, 
            'check_in' => $checkIn5->toDateString(),
            'check_out' => $checkOut5->toDateString(),
            'status' => 'approved',
            'total_price' => $this->calculatePrice(1, $checkIn5, $checkOut5),
        ]);

        // 6. josiah sample 3
        $checkIn6 = Carbon::now()->addDays(2);
        $checkOut6 = Carbon::now()->addDays(3);
        Booking::create([
            'user_id' => 3, 
            'package_id' => 3, 
            'check_in' => $checkIn6->toDateString(),
            'check_out' => $checkOut6->toDateString(),
            'status' => 'approved',
            'total_price' => $this->calculatePrice(1, $checkIn6, $checkOut6),
        ]);
    }

    private function calculatePrice($packageId, Carbon $checkIn, Carbon $checkOut)
    {
        // Find the specific package in the database to get its exact price
        $package = Package::find($packageId);
        
        // Calculate the difference in days
        $days = $checkIn->diffInDays($checkOut);
        
        // If check-in and check-out are the same day (0 days diff), charge for 1 base day
        $billableDays = $days === 0 ? 1 : $days;
        
        return $package->price * $billableDays;
    }
}