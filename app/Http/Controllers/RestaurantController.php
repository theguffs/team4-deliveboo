<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Order;  // Aggiungi il modello Order
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Mostra i ristoranti
    public function index(Request $request)
    {
        // Se è una richiesta API, restituisci il JSON dei ristoranti
        if ($request->wantsJson()) {
            $restaurants = Restaurant::with('categories', 'products')->get();
            return response()->json($restaurants);
        }

        // Se è una richiesta HTML (es. navigazione della dashboard), mostra la vista
        if (Auth::check()) {
            $restaurant = Restaurant::where('user_id', Auth::id())
                ->with('categories', 'products')
                ->first();

            return view('admin.dashboard', compact('restaurant'));
        } else {
            return redirect()->route('login')->with('error', 'Devi essere autenticato per accedere alla dashboard');
        }
    }

    // Mostra un ristorante specifico
    public function show(string $id)
    {
        $query = Restaurant::where('id', $id)->with('categories', 'products');

        if (Auth::check()) {
            // Utente autenticato: limita al ristorante dell'utente
            $query->where('user_id', Auth::id());
        }

        $restaurant = $query->firstOrFail();
        return response()->json($restaurant);
    }

    // Crea un ristorante (solo per utenti autenticati)
    public function store(Request $request)
    {
        // Verifica se l'utente ha già un ristorante
        if (Auth::user()->restaurant) {
            return response()->json(['message' => 'Hai già un ristorante. Non puoi crearne più di uno.'], 400);
        }

        $this->authorize('create', Restaurant::class);

        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|string',
            'piva' => 'required|string|size:11|unique:restaurants',
            'image' => 'nullable|image',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        // Gestione immagine
        $image = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

        // Crea il ristorante e associa i dati
        $restaurant = Auth::user()->restaurant()->create([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'piva' => $request->piva,
            // Gestione dell'immagine
            'image' => $image, 
        ]);

        // Associa le categorie al ristorante
        if ($request->has('categories')) {
            $restaurant->categories()->attach($request->categories);
        }

        // Risposta di successo
        return response()->json([
            'message' => 'Ristorante creato con successo',
            'restaurant' => $restaurant->load('categories'),
            'imageurl' => $image ? asset('storage/' . $image) : null
        ], 201);
    }

    // Modifica un ristorante (solo per utenti autenticati)
    public function update(Request $request, string $id)
    {
        $restaurant = Restaurant::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Validazione dei dati
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|string',
            'piva' => 'required|string|size:11|unique:restaurants,piva,' . $restaurant->id,
            'image' => 'nullable|image',
            'categories' => 'required|array|exists:categories,id',
        ]);

        // Gestione dell'immagine, se presente
        $image = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : $restaurant->image;

        // Aggiornamento delle informazioni del ristorante
        $restaurant->update([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'piva' => $request->piva,
            'image' => $image,
        ]);

        // Sincronizza le categorie selezionate
        $restaurant->categories()->sync($request->categories);

        // Risposta di successo
        return response()->json([
            'message' => 'Ristorante aggiornato con successo',
            'restaurant' => $restaurant->load('categories'),
            'imageurl' => $image ? asset('storage/' . $image) : null
        ]);
    }

    // Elimina un ristorante (solo per utenti autenticati)
    public function destroy(string $id)
    {
        $restaurant = Restaurant::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $restaurant->delete();

        return response()->json(['message' => 'Ristorante eliminato con successo']);
    }

    // Recupera gli ordini di un ristorante specifico
    public function getOrders(string $restaurantId)
    {
        // Recupera il ristorante e i suoi ordini associati
        $restaurant = Restaurant::where('id', $restaurantId)->with('orders')->firstOrFail();

        // Restituisce i dati degli ordini in formato JSON
        return response()->json($restaurant->orders);
    }
}