@extends('layouts.app')

@section('page-title', 'Dettagli del Prodotto')

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center">{{ $product->name }}</h1>
                    <img src="{{ $product->image_url }}" alt="Immagine del prodotto" class="img-fluid mb-3">
                    <p><strong>Ingredienti:</strong> {{ $product->ingredients }}</p>
                    <p><strong>Prezzo:</strong> €{{ $product->price }}</p>
                    <p><strong>Visibilità:</strong> {{ $product->visible ? 'Visibile' : 'Non visibile' }}</p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Torna alla Dashboard</a>
                    <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?')">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection