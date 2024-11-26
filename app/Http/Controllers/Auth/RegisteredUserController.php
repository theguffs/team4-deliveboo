namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RestaurantController; // Importa il controller
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function store(Request $request, RestaurantController $restaurantController)
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

        // Crea il ristorante direttamente nel controller del ristorante
        $restaurantController->store($request, $user);

        return response()->json(['message' => 'Utente e ristorante creati con successo'], 201);
    }
}