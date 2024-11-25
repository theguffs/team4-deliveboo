<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Restaurant;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ottieni tutti i ristoranti dal database
        $restaurants = Restaurant::all();

        // Definisci i piatti specifici per ciascuna categoria di ristorante
        foreach ($restaurants as $restaurant) {
            // Piatti per "La Trattoria Italiana" e "La Trattoria" (categoria: Italiano)
            if ($restaurant->name == 'La Trattoria Italiana' || $restaurant->name == 'La Trattoria') {
                Product::create([
                    'name' => 'Spaghetti alla Carbonara',
                    'ingredients' => 'Pasta, Uova, Pecorino, Pancetta, Pepe',
                    'price' => 12.50,
                    'image' => 'images/carbonara.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Lasagna Tradizionale',
                    'ingredients' => 'Pasta all\'uovo, Ragù, Besciamella, Parmigiano',
                    'price' => 15.00,
                    'image' => 'images/lasagna.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Pizza Margherita',
                    'ingredients' => 'Pomodoro, Mozzarella, Basilico, Olio EVO',
                    'price' => 8.00,
                    'image' => 'images/pizza_margherita.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Tiramisù',
                    'ingredients' => 'Mascarpone, Uova, Savoiardi, Caffè, Cacao',
                    'price' => 6.00,
                    'image' => 'images/tiramisu.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Fettuccine al Ragù',
                    'ingredients' => 'Fettuccine, Ragù di carne, Parmigiano',
                    'price' => 13.00,
                    'image' => 'images/fettuccine_ragu.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            }
            // Piatti per "Sushi Zen" (categoria: Giapponese)
            elseif ($restaurant->name == 'Sushi Zen') {
                Product::create([
                    'name' => 'Sashimi Misto',
                    'ingredients' => 'Salmone, Tonno, Branzino, Gambero',
                    'price' => 18.00,
                    'image' => 'images/sashimi_misto.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Nigiri Sushi',
                    'ingredients' => 'Riso, Salmone, Gambero, Tonno',
                    'price' => 12.00,
                    'image' => 'images/nigiri.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Tempura di Gamberi',
                    'ingredients' => 'Gamberi, Pastella, Salsa di Soia',
                    'price' => 10.00,
                    'image' => 'images/tempura_gamberi.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Ramen di Maiale',
                    'ingredients' => 'Brodo, Noodles, Maiale, Uovo, Cipollotto',
                    'price' => 13.00,
                    'image' => 'images/ramen.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Mochi',
                    'ingredients' => 'Farina di riso, Zucchero, Ripieno di fagioli rossi',
                    'price' => 5.00,
                    'image' => 'images/mochi.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            }
            // Piatti per "El Mexicano" (categoria: Messicano)
            elseif ($restaurant->name == 'El Mexicano') {
                Product::create([
                    'name' => 'Tacos al Pastor',
                    'ingredients' => 'Tortilla, Maiale, Cipolla, Ananas, Coriandolo',
                    'price' => 8.50,
                    'image' => 'images/tacos_al_pastor.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Quesadilla',
                    'ingredients' => 'Tortilla, Formaggio, Pollo, Peperoni',
                    'price' => 7.00,
                    'image' => 'images/quesadilla.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Guacamole con Nachos',
                    'ingredients' => 'Avocado, Lime, Cipolla, Nachos',
                    'price' => 6.50,
                    'image' => 'images/guacamole.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Burrito di Manzo',
                    'ingredients' => 'Tortilla, Manzo, Fagioli, Riso, Salsa Piccante',
                    'price' => 9.50,
                    'image' => 'images/burrito.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Churros',
                    'ingredients' => 'Farina, Zucchero, Cannella, Cioccolato',
                    'price' => 4.50,
                    'image' => 'images/churros.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            }
            // Piatti per "The Green Cafe" (categoria: Vegetariano/Internazionale)
            elseif ($restaurant->name == 'The Green Cafe') {
                Product::create([
                    'name' => 'Insalata di Quinoa',
                    'ingredients' => 'Quinoa, Pomodorini, Cetriolo, Avocado, Mais',
                    'price' => 10.00,
                    'image' => 'images/insalata_quinoa.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Vegan Burger',
                    'ingredients' => 'Pane integrale, Burger vegetale, Insalata, Pomodoro',
                    'price' => 12.00,
                    'image' => 'images/vegan_burger.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Zuppa di Lenticchie',
                    'ingredients' => 'Lenticchie, Carote, Sedano, Spezie',
                    'price' => 8.00,
                    'image' => 'images/zuppa_lenticchie.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Falafel con Hummus',
                    'ingredients' => 'Ceci, Spezie, Hummus, Pita',
                    'price' => 9.00,
                    'image' => 'images/falafel.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Torta di Carote',
                    'ingredients' => 'Carote, Farina, Zucchero, Cannella',
                    'price' => 5.00,
                    'image' => 'images/torta_carote.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            }
        }
    }
}
