@extends('layouts.guest')

@section('main-content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email">
                Email
            </label>
            <input type="email" id="email" name="email">
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password">
        </div>

        <!-- Remember Me -->
        <div class="mt-4">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Remember me</span>
            </label>
        </div>

        <div class="mt-4">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit">
                Log in
            </button>
        </div>
    </form>
@endsection
