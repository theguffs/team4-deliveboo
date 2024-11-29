<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // Assicura che l'utente sia autenticato per le azioni che modificano i prodotti
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Mostra un elenco dei prodotti.
     */
    public function index()
    {
        // Recupera il ristorante dell'utente autenticato
        $restaurant = Auth::user()->restaurant;

        // Recupera i prodotti del ristorante se il ristorante esiste
        $products = $restaurant ? $restaurant->products : collect();

        // Passa i prodotti alla vista dashboard
        return view('admin.dashboard', compact('products'));
    }

    /**
     * Mostra il form per creare un nuovo prodotto (solo per utenti autenticati).
     */
    public function create()
    {
        if (!Auth::user()->restaurant) {
            return redirect()->route('home')->with('error', 'Devi prima registrare un ristorante!');
        }

        // Carica le categorie per il form di creazione del prodotto
        $categories = Category::all();

        return view('products.create');
    }

    /**
     * Salva un nuovo prodotto nel database.
     */
    public function store(Request $request)
    {
        // Valida i dati inviati nella richiesta
        $request->validate([
            'name' => 'required|max:255',
            'ingredients' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024',
        ]);

        $restaurant = Auth::user()->restaurant;

        if (!$restaurant) {
            return response()->json(['error' => 'Devi prima registrare un ristorante!'], 403);
        }

        // Gestisci il caricamento dell'immagine (se presente)
        $image = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : null;

        // Crea un nuovo prodotto associato al ristorante dell'utente
        $product = $restaurant->products()->create([
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'price' => $request->price,
            'image' => $image,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Prodotto creato con successo!');
        return response()->json($product, 201);
        
    }

    /**
     * Mostra i dettagli di un prodotto specifico.
     */
    public function show($id)
    {
        // Ottieni il prodotto richiesto che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);

        // Passa il prodotto alla vista
        return view('products.show', compact('product'));
    }

    /**
     * Mostra il form per modificare un prodotto esistente (solo per utenti autenticati).
     */
    public function edit($id)
    {
        // Ottieni il prodotto da modificare che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);

        // Passa il prodotto alla vista di modifica
        return view('products.edit', compact('product'));
    }

    /**
     * Aggiorna un prodotto esistente nel database.
     */
    public function update(Request $request, $id)
    {
        // Valida i dati inviati nella richiesta
        $request->validate([
            'name' => 'required|max:255',
            'ingredients' => 'nullable|max:1000',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024',
        ]);

        // Ottieni il prodotto da aggiornare che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);

        // Gestisci il caricamento dell'immagine (se presente)
        $image = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : $product->image;

        // Aggiorna i dati del prodotto
        $product->update([
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'price' => $request->price,
            'image' => $image,
        ]);

        if($request -> ajax()) {
            return response() -> json([
                 'success'  => true,
                 'data'  => $product,  
                 'message'  => 'il prodotto è stato aggiornato con successo!',          
            ]);
        }
        // Reindirizza alla dashboard con un messaggio di successo
        return redirect()->route('admin.dashboard')->with('success', 'Prodotto aggiornato con successo!');
        // return response()->json($product, 201);
    }

    /**
     * Rimuove un prodotto dal database.
     */
    public function destroy($id)
    {
        // Ottieni il prodotto da eliminare che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Prodotto cancellato con successo!');
    }

    public function toggleVisibility($id)
    {
        $product = $this->getUserProduct($id); // Usa il metodo esistente per ottenere il prodotto dell'utente autenticato

        // Alterna lo stato di visibilità del prodotto
        $product->visible = !$product->visible;
        $product->save();

        return redirect()->route('admin.dashboard')->with('success', 'Stato di visibilità del prodotto aggiornato con successo!');
    }

    /**
     * Metodo di supporto per ottenere un prodotto appartenente al ristorante dell'utente autenticato.
     */
    private function getUserProduct($id)
    {
        return Product::where('id', $id)
            ->where('restaurant_id', Auth::user()->restaurant->id ?? null)
            ->firstOrFail();
    }

}

