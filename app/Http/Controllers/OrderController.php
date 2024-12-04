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

        public function indexByRestaurant($restaurantId)
    {
        $orders = Order::with('products')
            ->where('restaurant_id', $restaurantId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Crea un nuovo ordine.
     * Gestisce sia gli utenti autenticati che non autenticati.
     */
    public function store(Request $request)
{
    // Valida i dati in arrivo
    $validatedData = $request->validate([
        'email' => 'required|email|max:100',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:255',
        'notes' => 'nullable|string|max:500',
        'price' => 'required|numeric|min:0',
        'customer' => 'required|string|max:100',
        'restaurant_id' => 'required|integer|exists:restaurants,id',
        'products' => 'required|array', // Aggiungi questa validazione per i prodotti
        'products.*.id' => 'required|integer|exists:products,id', // Ogni prodotto deve avere un id valido
        'products.*.quantity' => 'required|integer|min:1', // Quantità del prodotto
        'products.*.price' => 'required|numeric|min:0', // Prezzo del prodotto
    ]);

    // Crea un nuovo ordine
    $order = new Order();
    $order->email = $validatedData['email'];
    $order->phone = $validatedData['phone'];
    $order->address = $validatedData['address'];
    $order->notes = $validatedData['notes'] ?? null;
    $order->price = $validatedData['price'];
    $order->customer = $validatedData['customer'];
    $order->restaurant_id = $validatedData['restaurant_id'];
    $order->save();

     // Associa i prodotti all'ordine
     foreach ($validatedData['products'] as $product) {
        $order->products()->attach($product['id'], [
            'quantity' => $product['quantity'],
            'price' => $product['price'],
        ]);
    }

    return response()->json([
        'success' => true,
        'order' => $order,
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
