<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    // Update this to include 'number'
    protected $fillable = ['name', 'role', 'staff_type', 'contact_number', 'email'];
}