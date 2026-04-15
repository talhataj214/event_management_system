@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Login</h2>

    @if ($errors->any())
        <div class="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            required
        >

        <label style="margin-top: 12px; font-weight: normal;">
            <input type="checkbox" name="remember" style="width: auto;">
            Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <p class="text-center mt-3">
        Don't have an account?
        <a href="{{ route('register') }}">Register</a>
    </p>
</div>
@endsection