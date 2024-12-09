@extends('layouts.guest')

@section('main-content')

    <div class="card">
        <div class="card-header">
            <span class="fs-3">Login</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
        
                <!-- Email Address -->
                <div>
                    <label for="email" class="w-100">
                        Email:
                    </label>
                    <input type="email" id="email" name="email">
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="w-100">
                        Password:
                    </label>
                    <input type="password" id="password" name="password">
                </div>
        
                <!-- Remember Me -->
                <div class="mt-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault remember_me">
                        <label class="form-check-label" for="remember_me">
                            Ricordami
                        </label>
                </div>
        
                <div class="mt-4">
                    <button type="submit" class="ms-4 border border-0 px-3 py-2 bg-success text-light rounded-pill">
                        Log in
                    </button>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-underline-light fs-6">
                            <span class="fs-6 text-black">{{ __('Password dimenticata?') }}</span>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    
@endsection
