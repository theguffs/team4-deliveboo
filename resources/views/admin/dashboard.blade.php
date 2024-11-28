@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center text-success">
                        Sei loggato!
                    </h1>

                    <!-- Messaggio di successo -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <br>
                    <a href="{{ route('admin.product.create') }}" class="btn btn-primary mb-3">Crea Nuovo Prodotto</a>

                    <h3>I Tuoi Prodotti</h3>
                    
                    @if($restaurant->products->isEmpty())
                        <p>Non hai prodotti registrati.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrizione</th>
                                    <th>Prezzo</th>
                                    <th>Visibile</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurant->products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->ingredients }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>
                                            <form action="{{ route('admin.product.toggleVisibility', $product->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm {{ $product->visible ? 'btn-success' : 'btn-secondary' }}">
                                                    {{ $product->visible ? 'Visibile' : 'Non visibile' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.product.show', $product->id) }}" class="btn btn-primary btn-sm">Vedi Dettagli</a>
                                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                                            <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?')">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection