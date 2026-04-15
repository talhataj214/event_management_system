<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with('event')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function show(string $id): View
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    public function store(Request $request, string $eventId): RedirectResponse
    {
        $request->validate([
            'number_of_seats_booked' => ['required', 'integer', 'min:1'],
        ]);

        $event = Event::findOrFail($eventId);
        $requestedSeats = (int) $request->number_of_seats_booked;

        if ($event->available_seats < $requestedSeats) {
            return back()->with('error', 'Not enough seats available.');
        }

        Booking::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'number_of_seats_booked' => $requestedSeats,
            'booking_status' => 'booked',
            'booking_date' => now(),
        ]);

        $event->decrement('available_seats', $requestedSeats);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function edit(string $id): View
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($booking->booking_status === 'cancelled') {
            return abort(403, 'Cancelled bookings cannot be edited.');
        }

        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'Cancelled bookings cannot be updated.');
        }

        $request->validate([
            'number_of_seats_booked' => ['required', 'integer', 'min:1'],
        ]);

        $newSeats = (int) $request->number_of_seats_booked;
        $oldSeats = (int) $booking->number_of_seats_booked;
        $difference = $newSeats - $oldSeats;

        if ($difference > 0 && $booking->event->available_seats < $difference) {
            return back()->with('error', 'Not enough available seats to update this booking.');
        }

        if ($difference > 0) {
            $booking->event->decrement('available_seats', $difference);
        } elseif ($difference < 0) {
            $booking->event->increment('available_seats', abs($difference));
        }

        $booking->update([
            'number_of_seats_booked' => $newSeats,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function cancel(string $id): RedirectResponse
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($booking->booking_status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        $booking->update([
            'booking_status' => 'cancelled',
        ]);

        $booking->event->increment('available_seats', $booking->number_of_seats_booked);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $booking = Booking::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        if ($booking->booking_status === 'booked') {
            $booking->event->increment('available_seats', $booking->number_of_seats_booked);
        }

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }
}