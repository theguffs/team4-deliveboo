@extends('layouts.app')

@section('page-title', 'Crea Prodotto')

@section('main-content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center text-success">Crea un nuovo prodotto</h1>
                    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nome del Prodotto -->
                        <div class="form-group">
                            <label for="name">Nome del Prodotto</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <!-- Ingredienti del Prodotto -->
                        <div class="form-group mt-3">
                            <label for="ingredients">Ingredienti</label>
                            <textarea id="ingredients" name="ingredients" class="form-control"></textarea>
                        </div>

                        <!-- Prezzo del Prodotto -->
                        <div class="form-group mt-3">
                            <label for="price">Prezzo</label>
                            <input type="number" id="price" name="price" step="0.01" class="form-control" required>
                        </div>

                        <!-- Immagine del Prodotto -->
                        <div class="form-group mt-3">
                            <label for="image">Immagine del Prodotto</label>
                            <input type="file" id="image" name="image" class="form-control-file">
                        </div>

                        <!-- Bottone per Inviare il Form -->
                        <button type="submit" class="btn btn-primary mt-4">Crea Prodotto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection