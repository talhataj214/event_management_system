@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Event</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom: 15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('events.store') }}" method="POST">
        @csrf

        <div style="margin-bottom: 10px;">
            <label for="title">Title</label><br>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="description">Description</label><br>
            <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="location">Location</label><br>
            <input type="text" name="location" id="location" value="{{ old('location') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="event_datetime">Event Date & Time</label><br>
            <input type="datetime-local" name="event_datetime" id="event_datetime" value="{{ old('event_datetime') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="total_seats">Total Seats</label><br>
            <input type="number" name="total_seats" id="total_seats" min="1" value="{{ old('total_seats') }}" required>
        </div>

        <button type="submit">Create Event</button>
        <a href="{{ route('events.index') }}">Cancel</a>
    </form>
</div>
@endsection