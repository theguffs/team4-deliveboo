@extends('layouts.app')

@section('page-title', 'Statistiche Ordini')

@section('main-content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h3>Statistiche degli Ordini per il Ristorante {{ $restaurant->name }}</h3>

                @if($ordersStats->isEmpty())
                    <p>Non ci sono ordini registrati per le statistiche.</p>
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