<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(){
        //devi essere autenticato per aver accesso a qualsiasi cosa di questo controller
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $restaurant = Auth::user()->restaurant;

    if (!$restaurant) {
        return redirect()->route('home')->with('error', 'Devi prima registrare un ristorante!');
    }

    $products = Product::where('restaurant_id', $restaurant->id)->get();
    return view('products.index', compact('products'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    if (!Auth::user()->restaurant) {
        return redirect()->route('home');
    }

    return view('products.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|max:255',
        'ingredients' => 'nullable|max:1000',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:1024',
    ]);

    // Controlla se l'utente ha un ristorante
    $restaurant = Auth::user()->restaurant;

    if (!$restaurant) {
        return redirect()->route('home');
    }

    // Gestione immagine
    $image = $request->hasFile('image') 
        ? $request->file('image')->store('images', 'public') 
        : null;

    // Crea il prodotto associato al ristorante dell'utente
    $product = Product::create([
        'name' => $request->name,
        'ingredients' => $request->ingredients,
        'price' => $request->price,
        'image' => $image,
        'restaurant_id' => $restaurant->id, // Associazione al ristorante
    ]);

    return redirect()->route('products.index');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $product = Product::where('id', $id)
        ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
        ->firstOrFail();

    return view('products.show', compact('product'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $product = Product::where('id', $id)
        ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
        ->firstOrFail();

    return view('products.edit', compact('product'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image',
        ]);
    
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();
    
        $image = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : $product->image;
    
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image,
        ]);
    
        return redirect()->route('products.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::where('id', $id)
        ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
        ->firstOrFail();

    $product->delete();

    return redirect()->route('products.index');
}
}