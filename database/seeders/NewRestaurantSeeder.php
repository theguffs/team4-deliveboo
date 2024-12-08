<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Dish;
use App\Models\User;

class NewRestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Trova gli utenti senza ristoranti
        $usersWithoutRestaurants = User::whereDoesntHave('restaurant')->get();

        // Dati per i ristoranti
        $restaurantData = [
            [
                'name' => 'Ristorante Amalfi',
                'address' => 'Via Roma 15, Milano',
                'description' => 'Cucina tradizionale italiana con un tocco moderno.',
                'piva' => '12345678902',
                'image' => 'restaurants/amalfi.png',
                'categories' => [1, 9],
            ],
            [
                'name' => 'Tokyo Sushi',
                'address' => 'Piazza Sakura 18, Milano',
                'description' => 'Autentico sushi giapponese e ramen.',
                'piva' => '98765432102',
                'image' => 'restaurants/tokyo-sushi.png',
                'categories' => [4, 7],
            ],
            [
                'name' => 'El Gaucho',
                'address' => 'Viale Argentina 22, Milano',
                'description' => 'Carne e barbecue in stile argentino.',
                'piva' => '56789012346',
                'image' => 'restaurants/el-gaucho.png',
                'categories' => [5, 8],
            ],
            [
                'name' => 'Veggie World',
                'address' => 'Via Verde 30, Milano',
                'description' => 'Cucina vegetariana e vegana moderna.',
                'piva' => '99887766556',
                'image' => 'restaurants/veggie-world.png',
                'categories' => [2, 7],
            ],
            [
                'name' => 'Pizza Napoli',
                'address' => 'Piazza Napoli 12, Milano',
                'description' => 'La vera pizza napoletana con forno a legna.',
                'piva' => '55667788992',
                'image' => 'restaurants/pizza-napoli.png',
                'categories' => [1, 9],
            ],
            [
                'name' => 'French Bistro',
                'address' => 'Piazza Francia 5, Milano',
                'description' => 'Elegante bistrot francese con piatti gourmet.',
                'piva' => '33445566779',
                'image' => 'restaurants/french-bistro.png',
                'categories' => [2, 8],
            ],
            [
                'name' => 'TexMex Fiesta',
                'address' => 'Via Fiesta 8, Milano',
                'description' => 'Cucina messicana autentica con barbecue Tex-Mex.',
                'piva' => '55667788993',
                'image' => 'restaurants/texmex-fiesta.png',
                'categories' => [5, 8],
            ],
            [
                'name' => 'Healthy Bowls',
                'address' => 'Via Salute 10, Milano',
                'description' => 'Cucina salutare con ingredienti biologici.',
                'piva' => '77889900113',
                'image' => 'restaurants/healthy-bowls.png',
                'categories' => [2, 7],
            ],
            [
                'name' => 'Ramen House',
                'address' => 'Via Tokyo 12, Milano',
                'description' => 'Ramen giapponese tradizionale.',
                'piva' => '98765432103',
                'image' => 'restaurants/ramen-house.png',
                'categories' => [4, 7],
            ],
            [
                'name' => 'Pasta Fresca',
                'address' => 'Via Pasta 20, Milano',
                'description' => 'Specialità di pasta fresca fatta in casa.',
                'piva' => '12345678903',
                'image' => 'restaurants/pasta-fresca.png',
                'categories' => [1, 8],
            ],
        ];

        foreach ($usersWithoutRestaurants as $index => $user) {
            if (isset($restaurantData[$index])) {
                $data = $restaurantData[$index];

                // Crea il ristorante e assegna l'utente
                $restaurant = Restaurant::create([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'description' => $data['description'],
                    'piva' => $data['piva'],
                    'image' => $data['image'],
                    'user_id' => $user->id,
                ]);

                // Associa le categorie
                $restaurant->categories()->attach($data['categories']);
            }
        }
    }
}
