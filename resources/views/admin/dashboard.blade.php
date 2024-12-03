@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('main-content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center text-success">Bentornat* {{ $restaurant->user->name }} <br> del ristorante {{ $restaurant->name }}</h1>

                <!-- Messaggio di successo -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <br>
                <!-- Sezione Prodotti -->
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
                                    <td>{{ $product->price }} <span>&#8364;</span></td>
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
                <!-- Sezione Statistiche -->
                <h3>Statistiche degli Ordini</h3>
               @if(isset($ordersStats) && !$ordersStats->isEmpty())
                    <p class="text-center">Non ci sono ancora ordini registrati.</p>
                @else
                    <canvas id="ordersChart"></canvas>
                @endif
                <script>
                    @php
                        $ordersStats = $ordersStats ?? collect([]); // Inizializza come collezione vuota se non definita
                    @endphp
                    // Recupera i dati degli ordini passati dal controller
                    const ordersStats = @json($ordersStats);

                    // Estrai i dati per il grafico
                    const months = ordersStats.map(stat => `${stat.month}-${stat.year}`);
                    const orderCounts = ordersStats.map(stat => stat.total_orders);
                    const salesAmounts = ordersStats.map(stat => stat.total_sales);

                    // Crea il grafico degli ordini
                    const ctxOrders = document.getElementById('ordersChart').getContext('2d');
                    new Chart(ctxOrders, {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [
                                {
                                    label: 'Numero di Ordini',
                                    data: orderCounts,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Ammontare delle Vendite (€)',
                                    data: salesAmounts,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mese-Anno'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Quantità'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
