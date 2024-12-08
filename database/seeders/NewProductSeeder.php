<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Restaurant;

class NewProductSeeder extends Seeder
{
    public function run()
    {
        $restaurants = Restaurant::where('id', '>=', 5)->get();

        foreach ($restaurants as $restaurant) {
            if ($restaurant->name == 'Pizza Napoli') {
                Product::create([
                    'name' => 'Margherita Speciale',
                    'ingredients' => 'Pomodoro, Mozzarella di Bufala, Basilico, Olio EVO',
                    'price' => 9.50,
                    'image' => 'images/margherita_speciale.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Pizza Diavola',
                    'ingredients' => 'Pomodoro, Mozzarella, Salame Piccante',
                    'price' => 11.00,
                    'image' => 'images/pizza_diavola.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Calzone',
                    'ingredients' => 'Prosciutto Cotto, Mozzarella, Pomodoro',
                    'price' => 10.00,
                    'image' => 'images/calzone.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Pizza Capricciosa',
                    'ingredients' => 'Pomodoro, Mozzarella, Funghi, Prosciutto, Olive',
                    'price' => 12.00,
                    'image' => 'images/capricciosa.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Pizza Quattro Formaggi',
                    'ingredients' => 'Mozzarella, Gorgonzola, Parmigiano, Provola',
                    'price' => 13.00,
                    'image' => 'images/quattro_formaggi.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'French Bistro') {
                Product::create([
                    'name' => 'Croque Monsieur',
                    'ingredients' => 'Pane, Prosciutto, Formaggio, Besciamella',
                    'price' => 7.50,
                    'image' => 'images/croque_monsieur.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Soupe à l\'oignon',
                    'ingredients' => 'Cipolle, Brodo di Manzo, Pane, Formaggio',
                    'price' => 8.50,
                    'image' => 'images/soupe_oignon.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Tarte Tatin',
                    'ingredients' => 'Mele, Zucchero, Burro, Pasta Brisée',
                    'price' => 6.00,
                    'image' => 'images/tarte_tatin.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Filetto al Pepe Verde',
                    'ingredients' => 'Filetto di Manzo, Pepe Verde, Panna',
                    'price' => 20.00,
                    'image' => 'images/filetto_pepe.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Crêpes Suzette',
                    'ingredients' => 'Crêpes, Arancia, Grand Marnier',
                    'price' => 8.00,
                    'image' => 'images/crepes_suzette.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'TexMex Fiesta') {
                Product::create([
                    'name' => 'Nachos con Chili',
                    'ingredients' => 'Nachos, Fagioli, Manzo, Salsa Piccante',
                    'price' => 9.00,
                    'image' => 'images/nachos_chili.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Enchiladas',
                    'ingredients' => 'Tortilla, Pollo, Salsa Rossa, Formaggio',
                    'price' => 11.50,
                    'image' => 'images/enchiladas.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Fajitas di Manzo',
                    'ingredients' => 'Manzo, Peperoni, Cipolle, Spezie',
                    'price' => 12.00,
                    'image' => 'images/fajitas.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Tostadas',
                    'ingredients' => 'Tortilla, Fagioli, Lattuga, Pomodori',
                    'price' => 8.00,
                    'image' => 'images/tostadas.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Chili con Carne',
                    'ingredients' => 'Manzo, Fagioli, Spezie, Pomodoro',
                    'price' => 10.00,
                    'image' => 'images/chili_con_carne.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'Veggie World') {
                Product::create([
                    'name' => 'Burger Vegetale',
                    'ingredients' => 'Pane integrale, Burger di ceci, Insalata, Pomodoro',
                    'price' => 12.00,
                    'image' => 'images/burger_vegetale.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Zuppa di Verdure',
                    'ingredients' => 'Carote, Patate, Zucchine, Brodo vegetale',
                    'price' => 9.00,
                    'image' => 'images/zuppa_verdure.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Insalata Mista',
                    'ingredients' => 'Lattuga, Pomodori, Cetrioli, Olive',
                    'price' => 8.00,
                    'image' => 'images/insalata_mista.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Wrap Vegetariano',
                    'ingredients' => 'Tortilla, Hummus, Verdure grigliate, Rucola',
                    'price' => 10.00,
                    'image' => 'images/wrap_vegetariano.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Brownie Vegano',
                    'ingredients' => 'Farina, Zucchero, Cioccolato fondente, Latte vegetale',
                    'price' => 5.50,
                    'image' => 'images/brownie_vegano.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'Healthy Bowls') {
                Product::create([
                    'name' => 'Poke Bowl al Salmone',
                    'ingredients' => 'Riso, Salmone, Avocado, Edamame, Salsa di Soia',
                    'price' => 14.00,
                    'image' => 'images/poke_salmone.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Smoothie Bowl',
                    'ingredients' => 'Banana, Fragole, Granola, Semi di chia',
                    'price' => 8.50,
                    'image' => 'images/smoothie_bowl.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Avocado Toast',
                    'ingredients' => 'Pane integrale, Avocado, Pomodorini, Semi di sesamo',
                    'price' => 7.00,
                    'image' => 'images/avocado_toast.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Bowl di Quinoa',
                    'ingredients' => 'Quinoa, Ceci, Verdure fresche, Limone',
                    'price' => 11.00,
                    'image' => 'images/quinoa_bowl.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Torta di Mele Integrale',
                    'ingredients' => 'Farina integrale, Mele, Cannella, Zucchero di canna',
                    'price' => 6.00,
                    'image' => 'images/torta_mele_integrale.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'Ramen House') {
                Product::create([
                    'name' => 'Tonkotsu Ramen',
                    'ingredients' => 'Brodo di maiale, Noodles, Uovo, Cipollotto',
                    'price' => 12.00,
                    'image' => 'images/tonkotsu_ramen.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Shoyu Ramen',
                    'ingredients' => 'Brodo di soia, Noodles, Pollo, Alga Nori',
                    'price' => 11.00,
                    'image' => 'images/shoyu_ramen.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Ramen Vegetariano',
                    'ingredients' => 'Brodo vegetale, Noodles, Verdure, Tofu',
                    'price' => 10.00,
                    'image' => 'images/ramen_vegetariano.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Gyoza',
                    'ingredients' => 'Ravioli giapponesi, Maiale, Cavolo, Salsa di Soia',
                    'price' => 6.50,
                    'image' => 'images/gyoza.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Mochi Gelato',
                    'ingredients' => 'Farina di riso, Gelato, Zucchero',
                    'price' => 5.00,
                    'image' => 'images/mochi_gelato.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            } elseif ($restaurant->name == 'Pasta Fresca') {
                Product::create([
                    'name' => 'Tagliatelle al Tartufo',
                    'ingredients' => 'Tagliatelle fresche, Tartufo, Burro',
                    'price' => 15.00,
                    'image' => 'images/tagliatelle_tartufo.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Ravioli Ricotta e Spinaci',
                    'ingredients' => 'Ravioli freschi, Ricotta, Spinaci, Burro e Salvia',
                    'price' => 13.00,
                    'image' => 'images/ravioli_ricotta.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Tortellini in Brodo',
                    'ingredients' => 'Tortellini freschi, Brodo di carne',
                    'price' => 12.00,
                    'image' => 'images/tortellini_brodo.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Lasagna al Forno',
                    'ingredients' => 'Pasta fresca, Ragù, Besciamella, Parmigiano',
                    'price' => 14.00,
                    'image' => 'images/lasagna_fresca.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => true,
                ]);
                Product::create([
                    'name' => 'Panna Cotta',
                    'ingredients' => 'Panna, Zucchero, Gelatina, Frutti di Bosco',
                    'price' => 5.50,
                    'image' => 'images/panna_cotta.jpg',
                    'restaurant_id' => $restaurant->id,
                    'visible' => false,
                ]);
            }
        }
    }
}
