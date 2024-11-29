@extends('layouts.app')

@section('page-title', 'Modifica Prodotto')

@section('main-content')
    <div class="container">
        <h1 class="mb-4">Modifica Prodotto</h1>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Nome</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="ingredients">Ingredienti</label>
                <textarea name="ingredients" id="ingredients" class="form-control" rows="4">{{ $product->ingredients }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="price">Prezzo
                    <span>&#8364;</span>
                </label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="image">Immagine del prodotto</label>
                @if($product->image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Immagine del prodotto" width="150">
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-warning">Aggiorna Prodotto</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annulla</a>
        </form>
    </div>
@endsection