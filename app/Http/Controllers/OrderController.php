<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra gli ordini ricevuti dal ristorante autenticato, ordinati per data.
     */
     public function index(Request $request)
    {
        // Verifica che l'utente abbia un ristorante associato
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'Devi prima registrare un ristorante!');
        }

        // Ottieni gli ordini del ristorante autenticato, ordinati per data decrescente
        $orders = Order::where('restaurant_id', $restaurant->id)
                        ->with('products') // Ottieni i prodotti associati all'ordine
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Se la richiesta è di tipo JSON, ritorna i dati in formato JSON
        if ($request->wantsJson()) {
            return response()->json($orders);
        }

        // Altrimenti, restituisci la vista con gli ordini
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     * Mostra i dettagli di un ordine specifico.
     * Risponde anche con JSON se la richiesta è un'API.
     */
    public function show($id, Request $request)
    {
        // Verifica che l'utente ristoratore possa vedere solo gli ordini del suo ristorante
        $restaurant = Auth::user()->restaurant;
        if (!$restaurant) {
            return redirect()->route('home')->with('error', 'Devi prima registrare un ristorante!');
        }

        // Ottieni l'ordine specifico del ristorante autenticato
        $order = Order::where('id', $id)
                      ->where('restaurant_id', $restaurant->id) // Filtra gli ordini per il ristorante dell'utente
                      ->with('products') // Ottieni i prodotti associati all'ordine
                      ->firstOrFail();

        // Se la richiesta è di tipo JSON, ritorna i dati in formato JSON
        if ($request->wantsJson()) {
            return response()->json($order);
        }

        // Altrimenti, restituisci la vista con i dettagli dell'ordine
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for creating a new resource.
     * Questa funzione può essere utilizzata per la creazione di ordini,
     * ma dal punto di vista del ristoratore non è necessaria, poiché solo l'utente cliente può fare ordini.
     */
    public function create()
    {
        // L'utente ristoratore non deve poter creare ordini, quindi può essere lasciato vuoto.
        return redirect()->route('orders.index');
    }

    /**
     * Store a newly created resource in storage.
     * Poiché solo l'utente cliente può fare ordini, questo metodo non è necessario per i ristoratori.
     */
    public function store(Request $request)
    {
        return redirect()->route('orders.index');
    }


    /**
     * Show the form for editing the specified resource.
     * Anche questa funzione non è necessaria per il ristoratore, poiché gli ordini non sono modificabili dai ristoratori.
     */
    public function edit($id)
    {
        return redirect()->route('orders.index');
    }

    /**
     * Update the specified resource in storage.
     * Gli ordini non devono essere aggiornati dai ristoratori, quindi questa funzione non è necessaria.
     */
    public function update(Request $request, $id)
    {
        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     * Poiché gli ordini non possono essere eliminati dai ristoratori, questa funzione non è necessaria.
     */
    public function destroy($id)
    {
        return redirect()->route('orders.index');
    }
}