@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Booking Details</h2>

    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
    <p><strong>Event Title:</strong> {{ $booking->event->title }}</p>
    <p><strong>Description:</strong> {{ $booking->event->description }}</p>
    <p><strong>Location:</strong> {{ $booking->event->location }}</p>
    <p><strong>Event Date:</strong> {{ $booking->event->event_datetime?->format('Y-m-d H:i') }}</p>
    <p><strong>Seats Booked:</strong> {{ $booking->number_of_seats_booked }}</p>
    <p><strong>Status:</strong> {{ ucfirst($booking->booking_status) }}</p>
    <p><strong>Booking Date:</strong> {{ $booking->booking_date?->format('Y-m-d H:i') }}</p>

    <a href="{{ route('bookings.index') }}">Back to My Bookings</a>
</div>
@endsection