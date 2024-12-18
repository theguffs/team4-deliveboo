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
          Registrati
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
        
                <div class="d-flex">
                    <div>
                        <!-- Name -->
                        <div>
                            <label for="name">Nome</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Email Address -->
                        <div class="mt-4">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Password -->
                        <div class="mt-4">
                            <label for="password">Password</label>
                            <input id="password" type="password" name="password" required>
                            @error('password')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Confirm Password -->
                        <div class="mt-4">
                            <label for="password_confirmation">Conferma Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required>
                        </div>
                
                        <!-- Restaurant Name -->
                        <div class="mt-4">
                            <label for="restaurant_name">Nome Ristorante</label>
                            <input id="restaurant_name" type="text" name="restaurant_name" value="{{ old('restaurant_name') }}" required>
                            @error('restaurant_name')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address">Indirizzo</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Description -->
                        <div class="mt-4">
                            <label for="description">Descrizione</label>
                            <textarea id="description" name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- PIVA -->
                        <div class="mt-4">
                            <label for="piva">Partita IVA</label>
                            <input id="piva" type="text" name="piva" value="{{ old('piva') }}" required>
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
                            <input id="image" type="file" name="image">
                            @error('image')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                
                        <!-- Categories as Checkboxes -->
                        <div class="mt-4 ms-5">
                            <label for="categories">Categorie del Ristorante</label>
                            <div id="categories">
                                @foreach($categories as $category)
                                    <div>
                                        <input type="checkbox" id="category{{ $category->id }}" name="categories[]" value="{{ $category->id }}">
                                        <label for="category{{ $category->id }}">{{ $category->name }}</label>
                                        </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
        
                <div class="mt-4">
                    <a href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
        
                    <button type="submit" class="ms-4">
                        Register
                    </button>
                </div>
            </form>
        </div>
      </div>
    
@endsection