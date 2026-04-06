<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageBookingController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Get bookings where user_id matches or guest_email matches user's email
            $bookings = Booking::with('package')
                                ->where(function($query) use ($user) {
                                    $query->where('user_id', $user->id)
                                          ->orWhere('guest_email', $user->email);
                                })
                                ->orderBy('check_in', 'desc')
                                ->get();

            return view('manage.results', compact('bookings', 'user'));
        }

        return view('manage.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;

        // Get bookings where user_id belongs to user with that email or guest_email matches
        $bookings = Booking::with('package')
                            ->where(function($query) use ($email) {
                                $query->whereHas('user', function($q) use ($email) {
                                    $q->where('email', $email);
                                })
                                ->orWhere('guest_email', $email);
                            })
                            ->orderBy('check_in', 'desc')
                            ->get();

        if ($bookings->isEmpty()) {
            return back()->with('error', 'We couldn\'t find any records associated with that email.');
        }

        $user = User::where('email', $email)->first();
        
        // For guest bookings, use guest info from first booking
        if (!$user && $bookings->isNotEmpty()) {
            $guestBooking = $bookings->first();
            $user = (object) [
                'name' => $guestBooking->guest_name ?? 'Guest User',
                'email' => $email,
                'is_guest' => true,
            ];
        }

        return view('manage.results', compact('bookings', 'user'));
    }
}