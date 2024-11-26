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
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Se l'utente è autenticato, ottieni i prodotti associati al suo ristorante
            $restaurant = Auth::user()->restaurant;

            if (!$restaurant) {
                return response()->json(['error' => 'Devi prima registrare un ristorante!'], 403);
            }

            // Ottieni i prodotti del ristorante dell'utente e le relative categorie
            $products = $restaurant->products()->with('categories')->get();
        } else {
            // Se l'utente non è autenticato, ottieni tutti i prodotti
            $query = Product::with('categories');

            // Se viene passato un parametro di categoria, filtra i prodotti per quella categoria
            if ($request->has('category')) {
                $categoryName = $request->category;

                // Trova la categoria con il nome passato
                $category = Category::where('name', $categoryName)->first();

                if ($category) {
                    // Restituisce solo i prodotti appartenenti alla categoria selezionata
                    $products = $category->products()->with('categories')->get();
                } else {
                    // Se la categoria non esiste, restituisce una lista vuota
                    $products = collect();
                }
            } else {
                // Se non viene specificata una categoria, mostra tutti i prodotti
                $products = $query->get();
            }
        }

        return response()->json($products);
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

        return view('products.create', compact('categories'));
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
            'categories' => 'required|array|exists:categories,id',
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

        // Associa il prodotto alle categorie selezionate
        $product->categories()->sync($request->categories);

        return response()->json($product, 201);
    }

    /**
     * Mostra i dettagli di un prodotto specifico.
     */
    public function show($id)
    {
        // Ottieni il prodotto richiesto insieme alle sue categorie
        $product = Product::with('categories')
            ->where('id', $id)
            ->firstOrFail();

        return response()->json($product);
    }

    /**
     * Mostra il form per modificare un prodotto esistente (solo per utenti autenticati).
     */
    public function edit($id)
    {
        // Ottieni il prodotto da modificare che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);

        // Carica tutte le categorie per il form di modifica del prodotto
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
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
            'categories' => 'required|array|exists:categories,id',
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

        // Associa le categorie selezionate al prodotto
        $product->categories()->sync($request->categories);

        return response()->json($product);
    }

    /**
     * Rimuove un prodotto dal database.
     */
    public function destroy($id)
    {
        // Ottieni il prodotto da eliminare che appartiene al ristorante dell'utente
        $product = $this->getUserProduct($id);
        $product->delete();

        return response()->json(['message' => 'Prodotto eliminato con successo'], 204);
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

