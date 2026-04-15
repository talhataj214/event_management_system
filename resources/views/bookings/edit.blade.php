@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Booking</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div style="color:red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <p><strong>Event:</strong> {{ $booking->event->title }}</p>
    <p><strong>Available Seats Right Now:</strong> {{ $booking->event->available_seats }}</p>
    <p><strong>Your Current Seats:</strong> {{ $booking->number_of_seats_booked }}</p>

    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 10px;">
            <label for="number_of_seats_booked">Number of Seats</label>
            <input
                type="number"
                name="number_of_seats_booked"
                id="number_of_seats_booked"
                min="1"
                value="{{ old('number_of_seats_booked', $booking->number_of_seats_booked) }}"
                required
            >
        </div>

        <button type="submit">Update Booking</button>
        <a href="{{ route('bookings.index') }}">Cancel</a>
    </form>
</div>
@endsection