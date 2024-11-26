<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
    {
        // Validazione dei dati (utente e ristorante)
        $request->validate([
            // Dati utente
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // Dati ristorante
            'restaurant_name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|string',
            'piva' => 'required|string|size:11|unique:restaurants,piva',
            'image' => 'nullable|image|max:1024',
        ]);

        // Crea l'utente
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Login utente
        Auth::login($user);

        // Gestione immagine (se presente)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Salva l'immagine nella cartella 'restaurants' dentro 'storage/app'
            $imagePath = $request->file('image')->store('restaurants', 'public');
        }

        // Crea il ristorante legato all'utente
        $restaurant = Restaurant::create([
            'user_id' => $user->id,  // Associa il ristorante all'utente
            'restaurant_name' => $request->restaurant_name,
            'address' => $request->address,
            'description' => $request->description,
            'piva' => $request->piva,
            'image' => $imagePath, // Salva il percorso dell'immagine
        ]);

        // Restituisci una risposta di successo con i dati utente e ristorante
        return response()->json([
            'message' => 'Utente e ristorante creati con successo',
            'user' => $user,
            'restaurant' => $restaurant
        ], 201);
    }
}