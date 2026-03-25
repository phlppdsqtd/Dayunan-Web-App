<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    // These match the columns in your database screenshot
    protected $fillable = [
        'title',
        'description',
        'price',
        'max_guests',
    ];

    // A package can have many bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}