<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RegisteredUserController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('auth.register', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validazione dei dati (utente e ristorante)
        $request->validate([
            // Dati utente
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            // Dati ristorante
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'description' => 'nullable|string',
            'piva' => 'required|string|size:11|unique:restaurants,piva',
            'image' => 'nullable|image|max:1024',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
        ]);

        // Crea l'utente
        $user = User::create([
            'user_name' => $request->user_name,
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
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'piva' => $request->piva,
            'image' => $imagePath, // Salva il percorso dell'immagine
        ]);

        // Associa le categorie al ristorante
        if ($request->has('categories')) {
            $restaurant->categories()->attach($request->categories);
        }

        // Reindirizza alla dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Utente e ristorante creati con successo');
    }
}