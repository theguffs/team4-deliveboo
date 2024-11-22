<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperiamo tutti i prodotti senza usare 'get()'
        $products = Product::all();
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
            'price' => 'required|decimal:0,2',
            'image' => 'nullable|image|max:1024',
        ]);

        
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
            'price' => 'required|decimal:0,2',
            'image' => 'nullable|image|max:1024',
        ]);

       
        $product = Product::findOrFail($id);


       
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
