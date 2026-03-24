<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::truncate();

        Contact::create([
            'name' => 'James',
            'role' => 'Front Desk',
            'staff_type' => 'Staff',
            'contact_number' => '09639595724',
            'email' => 'james@dayunan.com',
        ]);

        Contact::create([
            'name' => 'Jan',
            'role' => 'Admin',
            'staff_type' => 'Staff',
            'contact_number' => '09620560173',
            'email' => 'jan@dayunan.com',
        ]);
    }
}