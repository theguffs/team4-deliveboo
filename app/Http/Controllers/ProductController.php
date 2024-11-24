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
        // Recuperiamo tutti i prodotti dell'user
        $restaurant = Auth::user()->restaurant;
        if($restaurant){
            //mostra tutti i prodotti associati al ristorante
            $products = Product::where('restaurant_id', $restaurant->id)->get(); 
        }
        else{
            //altrimenti se non ha un ristorante restituisce un array vuoto
            $products = collect();
        }
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    // gestisce le immagini 

        if ($request->hasFile('image')) {
            //se esiste un file immagine caricato dall'utente lo salva in public
            $image = $request->file('image')->store('images', 'public');
        } else {
            //altrimenti  il campo è null e evita problemi con il DB
            $image = null;
        }

        //ristorante associato all'utente dell'accesso attuale
        $restaurant = Auth::user()->restaurant;
        
        $product = Product::create([
            'name' => $request->name,
            'ingredients' => $request->ingredients,
            'price' => $request->price,
            'image' => $image,
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
       
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1000',
            'price' => 'required||numeric|min:0',
            'image' => 'nullable|image',
        ]);

       
        $product = Product::findOrFail($id);

        //controllo per gestire l'aggionamento delle immagini
        if ($request->hasFile('image')) {
            // se esiste un file immagine caricato dall'utente lo salva in public
            $image = $request->file('image')->store('images', 'public');
        } else {
        // altrimenti mantiene l'immagine vecchia
            $image = $product->image;
        }
       
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
        
        $product = Product::findOrFail($id);

        
        $product->delete();

        return redirect()->route('products.index');
    }
}
