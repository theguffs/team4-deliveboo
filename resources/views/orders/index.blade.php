@extends('layouts.app')

@section('main-content')
<div class="container">
    <h1>Ordini fatti nel tuo Ristorante</h1>

    @if($orders->isEmpty())
        <p>Nessun ordine trovato per questo ristorante.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Indirizzo</th>
                    <th>Note</th>
                    <th>Prezzo Totale</th>
                    <th>Data</th>
                    <th>Prodotti</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->customer }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ $order->notes }}</td>
                        <td>{{ number_format($order->price, 2) }} €</td>
                        <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <ul>
                                @foreach($order->products as $product)
                                    <li>{{ $product->name }} (Quantità: {{ $product->pivot->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
