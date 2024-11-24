<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//importo il model di Restaurant
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mostra solo i ristoranti dell'utente autenticato
        $restaurants = Restaurant::where('user_id', Auth::id())->get();
        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('restaurants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validazione dati 
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|string',
            'piva' => 'required|string|size:11|unique',
            'image' => 'nullable|image',
            'categories' => 'required|array' //controlla se effettivasmente dia un array
        ]);

        if ($request->hasFile('image')) {
            //se esiste un file immagine caricato dall'utente lo salva in public
            $image = $request->file('image')->store('images', 'public');
        } else {
            //altrimenti  il campo è null e evita problemi con il DB
            $image = null;
        }

        //ristorante associato all'utente dell'accesso attuale
        $restaurant = Auth::user()->restaurant;

        $restaurant = Restaurant::create([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'piva' => $request->piva,
            'image' => $request->image,
        ]);
        $restaurant->categories()->sync($request->categories);

        return redirect()->route('restaurants.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
       return view('restaurants.show',compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validazione dati 
        $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|text',
            'piva' => 'required|string|size:11|unique',
            'image' => 'nullable|image',
            'categories' => 'required|array'
        ]);
        $restaurant = Restaurant::findOrFail($id);

        //controllo per gestire l'aggionamento delle immagini
        if ($request->hasFile('image')) {
            // se esiste un file immagine caricato dall'utente lo salva in public
            $image = $request->file('image')->store('images', 'public');
        } else {
        // altrimenti mantiene l'immagine vecchia
            $image = $restaurant->image;
        }
        
        $restaurant->update([
            'name'=> $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'piva'=> $request->piva,
            'image'=>$request->image
        ]);
        $restaurant->categories()->sync($request->categories);

        return redirect()->route('restaurants.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        return redirect()->route('restaurants.index');
    }
}
