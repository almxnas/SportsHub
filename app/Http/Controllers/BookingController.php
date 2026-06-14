<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request, Facility $facility)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $exists = Booking::where('facility_id', $facility->id)
            ->where('booking_date', $request->booking_date)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function ($q) use ($request) {
                      $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                  });
            })->exists();

        if ($exists) {
            return back()->with('error', 'Sorry, this time slot is already booked.');
        }

        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);
        $hours = $end->diffInMinutes($start) / 60;  // calculate exact hours including minutes
        $total = abs($hours * $facility->price_per_hour);  // force positive

        Booking::create([
            'user_id' => Auth::id(),
            'facility_id' => $facility->id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $total,
            'status' => 'confirmed',
        ]);

        return redirect()->route('my-bookings')->with('success', 'Booking successful!');
    }

    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->with('facility')->latest()->get();
        return view('bookings.my-bookings', compact('bookings'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking cancelled.');
    }
}