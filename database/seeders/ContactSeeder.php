<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'name' => 'Dayúnan Concierge',
            'email' => 'hello@dayunan.com',
            'number' => '09170000000',
        ]);

        Contact::create([
            'name' => 'Events Team',
            'email' => 'events@dayunan.com',
            'number' => '09171111111',
        ]);
    }
}