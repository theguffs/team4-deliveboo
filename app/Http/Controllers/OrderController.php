<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Mostra tutti gli ordini associati a un ristorante.
     * (per ristoratori, non per utenti non autenticati)
     */
    public function index(Request $request)
    {
        $restaurantId = $request->query('restaurant_id');
        if (!$restaurantId) {
            return response()->json(['error' => 'Restaurant ID è richiesto'], 400);
        }

        $orders = Order::where('restaurant_id', $restaurantId)
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Crea un nuovo ordine.
     * Gestisce sia gli utenti autenticati che non autenticati.
     */
    public function store(Request $request)
    {
        // Valida i dati in arrivo
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'email' => 'required|email|max:100',
            'telefono' => 'required|string|max:15',
            'indirizzo' => 'required|string|max:100',
            'note' => 'nullable|string|max:500',
            'cliente' => 'required|string|max:100',
        ]);

        // Crea un nuovo ordine
        $order = new Order();
        $order->restaurant_id = $validatedData['restaurant_id'];
        $order->email = $validatedData['email'];
        $order->telefono = $validatedData['telefono'];
        $order->indirizzo = $validatedData['indirizzo'];
        $order->note = $validatedData['note'] ?? null;
        $order->prezzo = $validatedData['total'];
        $order->cliente = $validatedData['cliente'];
        $order->save();

        // Associa i prodotti all'ordine con le relative quantità
        foreach ($validatedData['products'] as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json([
            'success' => true,
            'order' => $order->load('products'),
        ]);
    }

    /**
     * Mostra i dettagli di un ordine specifico.
     */
    public function show($id)
    {
        $order = Order::with('products')->findOrFail($id);

        return response()->json($order);
    }

    /**
     * Aggiorna lo stato di un ordine (solo per amministratori o ristoratori).
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:paid,preparing,delivered,canceled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $validatedData['status'];
        $order->save();

        return response()->json(['success' => true, 'order' => $order]);
    }

    /**
     * Elimina un ordine (opzionale, solo per amministratori).
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['success' => true, 'message' => 'Ordine eliminato']);
    }
}
