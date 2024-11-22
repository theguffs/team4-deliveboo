<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('products')->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validazione della richiesta
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:15',
            'address' => 'required|max:100',
            'notes' => 'nullable|string',
            'price' => 'required|decimal:2,2',
            'customer' => 'nullable|string|max:100',
            'products' => 'required|array', 
            'products.*.id' => 'required|exists:products,id', 
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Crea l'ordine
        $order = Order::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'price' => $request->price,
            'customer' => $request->customer,
        ]);

        
        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        
        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $order = Order::with('products')->findOrFail($id);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        $products = Product::all(); // Recupera tutti i prodotti disponibili
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $order = Order::findOrFail($id);

        
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|max:15',
            'address' => 'required|max:100',
            'notes' => 'nullable|string',
            'price' => 'required|decimal:2,2',
            'customer' => 'nullable|string|max:100',
            'products' => 'required|array', // Assicurati che venga passato un array di prodotti
            'products.*.id' => 'required|exists:products,id', // Verifica che ogni prodotto esista nel DB
            'products.*.quantity' => 'required|integer|min:1', // Quantità dei prodotti
        ]);

       
        $order->update([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'notes' => $request->notes,
            'price' => $request->price,
            'customer' => $request->customer,
        ]);

       
        $order->products()->detach();

        
        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        
        return redirect()->route('orders.show', $order->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $order = Order::findOrFail($id);
        $order->delete();

       
        return redirect()->route('orders.index');
    }
}
