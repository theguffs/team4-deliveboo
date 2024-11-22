<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//importo il model di Restaurant
use App\Models\Restaurant;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::all();
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
            'description' => 'nullable|text',
            'piva' => 'required|string|max:11',
            'image' => 'nullable|string|1024',
            'categories' => 'required|array' //controlla se effettivasmente dia un array
        ]);

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
            'piva' => 'required|string|max:11',
            'image' => 'nullable|string|1024',
            'categories' => 'required|array'
        ]);
        $restaurant = Restaurant::findOrFail($id);

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
