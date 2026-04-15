@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Event Details</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="color:red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p><strong>Title:</strong> {{ $event->title }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p><strong>Date & Time:</strong> {{ $event->event_datetime?->format('Y-m-d H:i') }}</p>
    <p><strong>Total Seats:</strong> {{ $event->total_seats }}</p>
    <p><strong>Available Seats:</strong> {{ $event->available_seats }}</p>
    <p><strong>Created By:</strong> {{ $event->creator?->name }}</p>

    @auth
        @if(auth()->user()->role === 'user')
            <hr>
            <h3>Book Seats</h3>

            @if($event->available_seats > 0)
                <form action="{{ route('bookings.store', $event->id) }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 10px;">
                        <label for="number_of_seats_booked">Number of Seats</label>
                        <input
                            type="number"
                            name="number_of_seats_booked"
                            id="number_of_seats_booked"
                            min="1"
                            max="{{ $event->available_seats }}"
                            required
                        >
                    </div>

                    <button type="submit">Book Now</button>
                </form>
            @else
                <p style="color:red;">No seats available.</p>
            @endif
        @endif

        @if(auth()->user()->role === 'admin')
            <div style="margin-top: 15px;">
                <a href="{{ route('events.edit', $event->id) }}">Edit Event</a>
            </div>
        @endif
    @endauth

    <div style="margin-top: 20px;">
        <a href="{{ route('events.index') }}">Back to Events</a>
    </div>
</div>
@endsection