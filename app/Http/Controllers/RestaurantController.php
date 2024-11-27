<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function getCategories(){$categories=Category::all();
        return response()->json($categories);
    }
    // Mostra i ristoranti
    public function index(Request $request)
    {
        if (Auth::check()) {
            // Utente autenticato: mostra solo il ristorante associato, incluse categorie e prodotti
            $restaurant = Restaurant::where('user_id', Auth::id())
                ->with('categories', 'products') // Aggiungi altre relazioni necessarie
                ->first();

            if ($restaurant) {
                return response()->json($restaurant);
            } else {
                return response()->json(['message' => 'Nessun ristorante associato a questo utente'], 404);
            }
        } else {
            // Utente non autenticato: mostra tutti i ristoranti, con la possibilità di filtrare per categoria
            $query = Restaurant::with('categories', 'products');

            // Se viene passato un parametro 'category', filtra i ristoranti per quella categoria
            if ($request->has('category')) {
                $categoryName = $request->category;

                // Trova la categoria con quel nome
                $category = Category::where('name', $categoryName)->first();

                if ($category) {
                    // Restituisce solo i ristoranti che appartengono alla categoria selezionata
                    $restaurants = $category->restaurants()->with('categories')->get();
                } else {
                    $restaurants = collect(); // Se la categoria non esiste, restituisce una lista vuota
                }
            } else {
                // Se non viene specificata una categoria, mostra tutti i ristoranti
                $restaurants = $query->get();
            }

            return response()->json($restaurants);
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
        'categories' => 'required|array|exists:categories,id',
    ]);

    // Gestione immagine
    $image = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

    // Crea il ristorante e associa i dati
    $restaurant = Auth::user()->restaurant()->create([
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
        'message' => 'Ristorante creato con successo',
        'restaurant' => $restaurant->load('categories'),
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
        ]);
    }

    // Elimina un ristorante (solo per utenti autenticati)
    public function destroy(string $id)
    {
        $restaurant = Restaurant::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $restaurant->delete();

        return response()->json(['message' => 'Ristorante eliminato con successo']);
    }
}