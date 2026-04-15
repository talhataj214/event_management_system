@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Events</h2>

    @if(session('success'))
        <div style="color: green; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @auth
        <div style="margin-bottom: 15px;">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('events.create') }}">Create New Event</a>
            @endif

            | <a href="{{ route('bookings.index') }}">My Bookings</a>
        </div>
    @endauth

    @if($events->count())
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th>Date & Time</th>
                    <th>Total Seats</th>
                    <th>Available Seats</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ $event->location }}</td>
                        <td>{{ $event->event_datetime?->format('Y-m-d H:i') }}</td>
                        <td>{{ $event->total_seats }}</td>
                        <td>{{ $event->available_seats }}</td>
                        <td>{{ $event->creator?->name }}</td>
                        <td>
                            <a href="{{ route('events.show', $event->id) }}">View</a>

                            @if(auth()->check() && auth()->user()->role === 'admin')
                                | <a href="{{ route('events.edit', $event->id) }}">Edit</a>

                                | <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this event?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No events found.</p>
    @endif
</div>
@endsection