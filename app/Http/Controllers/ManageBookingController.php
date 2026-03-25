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
            
            // Added with('package') to pull the package details (title, description, etc.)
            $bookings = Booking::with('package')
                                ->where('user_id', $user->id)
                                ->orderBy('check_in', 'desc')
                                ->get();

            return view('manage.results', compact('bookings', 'user'));
        }

        return view('manage.index');
    }

    public function search(Request $request)
    {
        // Security: If logged in, don't allow searching other emails
        if (Auth::check()) {
            return redirect()->route('manage.index');
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'We couldn\'t find any records associated with that email.');
        }

        // Added with('package') here as well for the guest search
        $bookings = Booking::with('package')
                            ->where('user_id', $user->id)
                            ->orderBy('check_in', 'desc')
                            ->get();

        return view('manage.results', compact('bookings', 'user'));
    }
}