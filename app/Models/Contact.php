<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Updated to match your migration fields exactly
    protected $fillable = [
        'name', 
        'role', 
        'staff_type', 
        'contact_number', 
        'email'
    ];
}