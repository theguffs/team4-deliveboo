<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Tronca le tabelle
        DB::table('restaurants')->truncate();
        DB::table('restaurant_category')->truncate();

        // Resetta l'auto increment
        DB::statement('ALTER TABLE restaurants AUTO_INCREMENT = 1');

        // Riabilita le constraint delle foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset dell'auto increment
        DB::statement('ALTER TABLE restaurants AUTO_INCREMENT = 1');
        $categories = Category::all();
       
        $restaurants = [
            [
                'name' => 'La Trattoria Italiana',
                'address' => 'Via Roma 10, Milano',
                'description' => 'Ristorante tradizionale italiano.',
                'piva' => '12345678901',
                'image' => 'images/the_green_cafe.jpg',
                'categories' => [1, 9],
                'user_id' => 1,
            ],
            [
                'name' => 'Sushi Zen',
                'address' => 'Piazza Sakura 5, Milano',
                'description' => 'Autentico sushi giapponese.',
                'piva' => '09876543210',
                'image' => 'images/the_green_cafe.jpg',
                'categories' => [4, 7],
                'user_id' => 2, 
            ],
            [
                'name' => 'El Mexicano',
                'address' => 'Calle Fiesta 20, Milano',
                'description' => 'Cucina messicana autentica e vivace.',
                'piva' => '56789012345',
                'image' => 'images/the_green_cafe.jpg',
                'categories' => [5, 8],
                'user_id' => 3, 
            ],
            [
                'name' => 'La Trattoria',
                'address' => 'Via Firenze 10, Milano',
                'description' => 'Trattoria tipica con piatti tradizionali italiani.',
                'piva' => '9988776655',
                'image' => 'images/la_trattoria.jpg',
                'categories' => [ 1 , 8], 
                'user_id' => 4, 
            ],
            [
                'name' => 'The Green Cafe',
                'address' => 'Viale della Repubblica 20, Milano',
                'description' => 'Caffè e ristorante con un menu vegetariano.',
                'piva' => '5566778899',
                'image' => 'images/the_green_cafe.jpg', 
                'categories' => [2 , 7], 
                'user_id' => 5,
            ]
        ];
foreach ($restaurants as $data) {
            // Creazione del ristorante
            $restaurant = Restaurant::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'description' => $data['description'],
                'piva' => $data['piva'],
                'image' => $data['image'],
                'user_id' => $data['user_id'],
            ]);
            $restaurant->categories()->attach($data['categories']);
        }
        
    }
}