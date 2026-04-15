@extends('layouts.app')

@section('content')
<div class="topbar">
    <h2>User Dashboard</h2>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

<div class="container">
    
    <p>Welcome, {{ auth()->user()->name }}</p>

    <a href="{{ route('events.index') }}">View Events</a> |
    <a href="{{ route('bookings.index') }}">My Bookings</a>
</div>
@endsection