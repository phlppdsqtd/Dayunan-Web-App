<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
class ManageBookingController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                $bookings = Booking::with('package', 'user')
                                    ->orderBy('check_in', 'desc')
                                    ->get();
                $packages = Package::where('is_active', true)->orderBy('title')->get();
                return view('manage.results', compact('bookings', 'user', 'packages'));
            }

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

    public function cancel(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled successfully.');
    }

    public function edit(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be edited.');
        }
        return view('manage.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403);
        }
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be edited.');
        }
        $request->validate([
            'check_in'  => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
        ]);
        $booking->update([
            'check_in'  => $request->check_in,
            'check_out' => $request->check_out,
        ]);
        return redirect()->route('manage.index')->with('success', 'Booking updated successfully.');
    }

    public function approve(Booking $booking)
    {
        $booking->update(['status' => 'approved']);
        return back()->with('success', 'Booking approved.');
    }

    public function changeStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,cancelled',
        ]);
        $booking->update(['status' => $request->status]);
        return redirect()->route('manage.admin.edit', $booking)->with('success', 'Status updated.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking permanently deleted.');
    }

    public function adminEdit(Booking $booking)
    {
        return view('manage.admin-edit', compact('booking'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $request->validate([
            'check_in'    => 'required|date',
            'check_out'   => 'required|date|after:check_in',
            'guest_name'  => 'nullable|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
        ]);

        $booking->update([
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'guest_name'  => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,
        ]);

        return redirect()->route('manage.index')->with('success', 'Booking updated successfully.');
    }
}