<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * This protects your database by only allowing these specific columns to be filled via forms.
     */
    protected $fillable = [
        'user_id',
        'package_id',
        'check_in',
        'check_out',
        'status',
        'total_price',
        'guest_name',
        'guest_email',
        'guest_phone',
    ];

    /**
     * The attributes that should be cast to native types.
     * This automatically turns your dates into Carbon objects so you can format them easily.
     */
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // A booking belongs to one specific package
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // A booking belongs to one specific user (guest)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}