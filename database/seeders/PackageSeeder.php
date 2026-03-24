<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- SMALL GATHERING ---
        Package::create([
            'title' => 'Small Gathering (22 Hours)',
            'description' => "• Up to 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Access for set-up of catering service is NOT included\n• 22-Hour Stay: ₱16,000 (2:00 PM to 12:00 NN)",
            'price' => 16000.00,
            'max_guests' => 24,
        ]);

        Package::create([
            'title' => 'Small Gathering (12 Hours)',
            'description' => "• Up to 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Access for set-up of catering service is NOT included\n• 12-Hour Stay: ₱12,000 (2:00 PM to 2:00 AM)",
            'price' => 12000.00,
            'max_guests' => 24,
        ]);

        // --- LARGE EVENT ---
        Package::create([
            'title' => 'Large Event (22 Hours)',
            'description' => "• More than 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Access for set-up of catering service and extra tables/chairs allowed\n• 22-Hour Stay: ₱25,000 (2:00 PM to 12:00 NN)",
            'price' => 25000.00,
            'max_guests' => 80,
        ]);

        Package::create([
            'title' => 'Large Event (12 Hours)',
            'description' => "• More than 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Access for set-up of catering service and extra tables/chairs allowed\n• 12-Hour Stay: ₱21,000 (2:00 PM to 2:00 AM)",
            'price' => 21000.00,
            'max_guests' => 80,
        ]);

        // --- LARGE EVENT WITH SOUND AND LIGHTS ---
        Package::create([
            'title' => 'Large Event with Sound & Lights (22 Hours)',
            'description' => "• More than 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Professional sound and lights system with operator included\n• Access for catering set-up and extra tables/chairs allowed\n• 22-Hour Stay: ₱37,000 (2:00 PM to 12:00 NN)",
            'price' => 37000.00,
            'max_guests' => 80,
        ]);

        Package::create([
            'title' => 'Large Event with Sound & Lights (12 Hours)',
            'description' => "• More than 24 guests allowed\n• Beds for up to 12 guests\n• Tables and chairs for 24 pax included\n• Professional sound and lights system with operator included\n• Access for catering set-up and extra tables/chairs allowed\n• 12-Hour Stay: ₱33,000 (2:00 PM to 2:00 AM)",
            'price' => 33000.00,
            'max_guests' => 80,
        ]);
    }
}