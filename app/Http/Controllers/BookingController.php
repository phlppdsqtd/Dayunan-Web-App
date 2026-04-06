<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $packages = Package::where('is_active', true)->get();
        $selectedPackage = null;
        if ($request->has('package_id')) {
            $selectedPackage = Package::find($request->package_id);
        }
        return view('pages.book', compact('packages', 'selectedPackage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'check_in' => 'required|date|after:now',
            'check_out' => 'required|date|after:check_in',
            'guest_name' => 'required_if:user_id,null|string|max:255',
            'guest_email' => 'required_if:user_id,null|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        // Check for overlapping approved bookings
        $existingBooking = Booking::where('status', 'approved')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereRaw('check_in < ?', [$checkOut->toDateTimeString()])
                      ->whereRaw('check_out > ?', [$checkIn->toDateTimeString()]);
            })
            ->exists();

        if ($existingBooking) {
            return redirect()->back()->with('error', 'This time period overlaps with an existing approved booking. Please select different dates.');
        }

        $package = Package::findOrFail($request->package_id);
        $days = $checkIn->diffInDays($checkOut);
        $billableDays = $days === 0 ? 1 : $days;
        $totalPrice = $package->price * $billableDays;

        $bookingData = [
            'package_id' => $request->package_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ];

        if (Auth::check()) {
            $bookingData['user_id'] = Auth::id();
        } else {
            $user = User::where('email', $request->guest_email)->first();
            if ($user) {
                $bookingData['user_id'] = $user->id;
            } else {
                $bookingData['guest_name'] = $request->guest_name;
                $bookingData['guest_email'] = $request->guest_email;
                $bookingData['guest_phone'] = $request->guest_phone;
            }
        }

        Booking::create($bookingData);

        return redirect()->back()->with('success', 'Booking submitted successfully! We will contact you soon.');
    }

    public function getBlockedDates()
    {
        $blockedRanges = Booking::where('status', 'approved')
            ->select('check_in', 'check_out')
            ->get()
            ->map(function ($booking) {
                return [
                    'start' => $booking->check_in->toIso8601String(),
                    'end' => $booking->check_out->toIso8601String(),
                ];
            })
            ->toArray();

        return response()->json($blockedRanges);
    }
}
