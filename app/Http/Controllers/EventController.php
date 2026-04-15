<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('creator')
            ->latest()
            ->get();

        return view('events.index', compact('events'));
    }

    public function show(string $id): View
    {
        $event = Event::with('creator')->findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_datetime' => ['required', 'date'],
            'total_seats' => ['required', 'integer', 'min:1'],
        ]);

        Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'],
            'event_datetime' => $validated['event_datetime'],
            'total_seats' => $validated['total_seats'],
            'available_seats' => $validated['total_seats'],
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(string $id): View
    {
        $event = Event::findOrFail($id);

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['required', 'string', 'max:255'],
            'event_datetime' => ['required', 'date'],
            'total_seats' => ['required', 'integer', 'min:1'],
        ]);

        $oldTotalSeats = (int) $event->total_seats;
        $oldAvailableSeats = (int) $event->available_seats;
        $newTotalSeats = (int) $validated['total_seats'];

        $bookedSeats = $oldTotalSeats - $oldAvailableSeats;

        if ($newTotalSeats < $bookedSeats) {
            return back()
                ->withErrors([
                    'total_seats' => 'Total seats cannot be less than already booked seats ('.$bookedSeats.').',
                ])
                ->withInput();
        }

        $newAvailableSeats = $newTotalSeats - $bookedSeats;

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'location' => $validated['location'],
            'event_datetime' => $validated['event_datetime'],
            'total_seats' => $newTotalSeats,
            'available_seats' => $newAvailableSeats,
        ]);

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }
}