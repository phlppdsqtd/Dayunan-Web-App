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
        $packages = Package::where('is_active', true)->orderBy('price', 'asc')->get();
        return view('pages.book', compact('packages'));
    }

    public function details(Package $package)
    {
        return view('pages.book.details', compact('package'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guest_name' => 'required_if:user_id,null|string|max:255',
            'guest_email' => 'required_if:user_id,null|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
        ]);

        $checkIn = Carbon::parse($request->check_in)->startOfDay();
        $checkOut = Carbon::parse($request->check_out)->startOfDay();

        // Check for overlapping approved bookings (date-based)
        $existingBooking = Booking::where('status', 'approved')
            ->where('package_id', $request->package_id)
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            })
            ->exists();


        if ($existingBooking) {
            return redirect()->back()->with('error', 'Selected dates overlap with an existing approved booking.');
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



    public function getBlockedDates(Package $package = null, Request $request)
    {
        $query = Booking::where('status', 'approved')
            ->select('id', 'check_in', 'check_out', 'package_id');
        
        $packageId = $package ? $package->id : ($request->package_id ?? null);
        if ($packageId) {
            $query->where('package_id', $packageId);
        }

        $blockedRanges = $query->get()
            ->map(function ($booking) {
                return [
                    'booking_id' => $booking->id,
                    'start_date' => $booking->check_in->format('Y-m-d'),
                    'end_date'   => $booking->check_out->subDay()->format('Y-m-d'),
                ];
            })
            ->toArray();

        return response()->json($blockedRanges);
    }



}
