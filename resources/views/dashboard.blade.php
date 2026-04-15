@extends('layouts.app')

@section('content')
<div class="topbar">
    <h2>Admin Dashboard</h2>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>




<div class="card">
    <h3>Welcome, {{ auth()->user()->name }}</h3>
    <p>You are logged in successfully.</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
</div>

@if(session('success'))
    <div class="card" style="margin-top: 20px; color: green;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="card" style="margin-top: 20px; color: red;">
        {{ session('error') }}
    </div>
@endif

<div class="card" style="margin-top: 20px;">
    <h3>System Overview</h3>

    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 180px; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
            <h4>Total Users</h4>
            <p style="font-size: 24px; margin: 0;">{{ $totalUsers }}</p>
        </div>

        <div style="flex: 1; min-width: 180px; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
            <h4>Total Events</h4>
            <p style="font-size: 24px; margin: 0;">{{ $totalEvents }}</p>
        </div>

        <div style="flex: 1; min-width: 180px; padding: 15px; border: 1px solid #ddd; border-radius: 8px;">
            <h4>Total Bookings</h4>
            <p style="font-size: 24px; margin: 0;">{{ $totalBookings }}</p>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 20px;">
    <h3>All Users</h3>

    @if($users->count())
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Current Role</th>
                    <th>Change Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <form action="{{ route('admin.users.role', $user->id) }}" method="POST" style="display:flex; gap:10px; align-items:center;">
                                @csrf
                                @method('PUT')

                                <select name="role">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>

                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No users found.</p>
    @endif
</div>
@endsection