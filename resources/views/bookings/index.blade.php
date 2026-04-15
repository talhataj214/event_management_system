@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Bookings</h2>

    @if (session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    @if($bookings->count())
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event</th>
                    <th>Location</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->event->title }}</td>
                        <td>{{ $booking->event->location }}</td>
                        <td>{{ $booking->number_of_seats_booked }}</td>
                        <td>{{ ucfirst($booking->booking_status) }}</td>
                        <td>{{ $booking->booking_date?->format('Y-m-d H:i') }}</td>
                        <td>
                            <a href="{{ route('bookings.show', $booking->id) }}">View</a>

                            @if($booking->booking_status === 'booked')
                                | <a href="{{ route('bookings.edit', $booking->id) }}">Edit</a>

                                | <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Cancel this booking?')">Cancel</button>
                                </form>
                            @endif

                            | <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this booking?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No bookings found.</p>
    @endif
</div>
@endsection