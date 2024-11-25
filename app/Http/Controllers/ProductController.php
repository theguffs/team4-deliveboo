<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Assicurati che l'utente sia autenticato per ogni azione in questo controller
        $this->middleware('auth');
    }

    /**
     * Display a listing of the products for the authenticated user's restaurant.
     */
    public function index()
    {
        // Ottieni il ristorante dell'utente autenticato
        $restaurant = Auth::user()->restaurant;

        // Se l'utente non ha un ristorante, reindirizza alla home con un messaggio di errore
        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'Devi prima registrare un ristorante!');
        }

        // Ottieni tutti i prodotti associati al ristorante
        $products = $restaurant->products;

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Controlla se l'utente ha un ristorante, altrimenti reindirizza alla home
        if (!Auth::user()->restaurant) {
            return redirect()->route('home');
        }

        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Valida i dati inviati tramite la richiesta
        $request->validate([
            'name' => 'required|max:255',
            'ingredients' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024',
        ]);

        // Ottieni il ristorante dell'utente autenticato
        $restaurant = Auth::user()->restaurant;

        // Se non c'Ã¨ un ristorante, reindirizza alla home
        if (!$restaurant) {
            return redirect()->route('home');
        }

        // Gestisci l'immagine del prodotto (se presente)
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
     * Display the specified product.
     */
    public function show($id)
    {
        // Ottieni il prodotto specificato, solo se appartiene al ristorante dell'utente
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        // Ottieni il prodotto da modificare, solo se appartiene al ristorante dell'utente
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();

        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        // Valida i dati inviati tramite la richiesta
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image',
        ]);

        // Ottieni il prodotto da aggiornare, solo se appartiene al ristorante dell'utente
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();

        // Gestisci l'immagine del prodotto (se presente)
        $image = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : $product->image;

        // Aggiorna i dati del prodotto
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $image,
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        // Ottieni il prodotto da eliminare, solo se appartiene al ristorante dell'utente
        $product = Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();

        // Elimina il prodotto
        $product->delete();

        return redirect()->route('products.index');
    }
}
