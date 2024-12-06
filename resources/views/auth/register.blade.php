@extends('layouts.guest')

@section('main-content')
<!--Se l'utente non è autenticato da errore-->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-header">
      <span class="fs-3">Registrati</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf
    
            <div class="d-flex flex-row justify-content-center">
                <div class="">
                    <!-- Name -->
                    <div>
                        <label for="user_name" class="w-100">Nome:</label>
                        <input id="user_name" type="text" name="user_name" value="{{ old('user_name') }}" required autofocus maxlength="255">
                        @error('name')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Email Address -->
                    <div class="mt-4">
                        <label for="email" class="w-100">Email:</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required maxlength="255">
                        @error('email')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="w-100">Password:</label>
                        <input id="password" type="password" name="password" required minlength="8">
                        @error('password')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <label for="password_confirmation" class="w-100">Conferma Password:</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>
            
                    <!-- Restaurant Name -->
                    <div class="mt-4">
                        <label for="name" class="w-100">Nome Ristorante:</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required maxlength="100">
                        @error('restaurant_name')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Address -->
                    <div class="mt-4">
                        <label for="address" class="w-100">Indirizzo:</label>
                        <input id="address" type="text" name="address" value="{{ old('address') }}" required maxlength="100">
                        @error('address')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Description -->
                    <div class="mt-4">
                        <label for="description" class="w-100">Descrizione:</label>
                        <textarea id="description" name="description" maxlength="255">{{ old('description') }}</textarea>
                        @error('description')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- PIVA -->
                    <div class="mt-4">
                        <label for="piva" class="w-100">Partita IVA:</label>
                        <input id="piva" type="text" name="piva" value="{{ old('piva') }}" required size="11">
                        @error('piva')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
        
                <div class="ms-5">
                    <!-- Restaurant Image -->
                    <div class="ms-5">
                        <div>
                            <label for="image">Immagine del Ristorante:</label>
                        </div>
                        <input id="image" type="file" name="image" accept="image/*">
                        @error('image')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
            
                    <!-- Categories as Checkboxes -->
                    <div class="mt-4 ms-5">
                        <label for="categories">Categorie del Ristorante</label>
                        <div id="categories">
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault category{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                                    <label class="form-check-label" for="flexCheckDefault category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                  </div>
                            @endforeach
                        </div>
                        @error('categories')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-4 px-5 justify-content-center">
                <div class="px-5 mx-5">
                    <button type="submit" class="ms-4 border border-0 px-3 py-2 bg-success text-light rounded-pill">
                        Register
                    </button>
                    <a href="{{ route('login') }}" class="link-underline-light fs-6">
                       <span class="fs-6 text-black">{{ __('Sei già registrato?') }}</span> 
                    </a>
                </div>
            </div>
    
        </form>
    </div>
</div>

@endsection
