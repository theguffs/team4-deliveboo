@extends('layouts.guest')

@section('main-content')
    <div>
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email">
                Email
            </label>
            <input type="email" id="email" name="email">
        </div>

        <div>
            <button type="submit">
                Email Password Reset Link
            </button>
        </div>
    </form>
@endsection
