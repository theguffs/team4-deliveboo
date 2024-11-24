<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Crea 5 utenti (uno per ciascun ristorante)
        $usersData = [
            [
                'name' => 'Mario Rossi',
                'email' => 'mario.rossi@example.com',
                'password' => bcrypt('password123'), // Usa bcrypt per una password sicura
            ],
            [
                'name' => 'Luca Bianchi',
                'email' => 'luca.bianchi@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Giulia Verdi',
                'email' => 'giulia.verdi@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Marco Neri',
                'email' => 'marco.neri@example.com',
                'password' => bcrypt('password123'),
            ],
            [
                'name' => 'Anna Gialli',
                'email' => 'anna.gialli@example.com',
                'password' => bcrypt('password123'),
            ]
        ];

        // Creazione degli utenti
        $users = collect($usersData)->map(function ($userData) {
            return User::create($userData);
        });

        // Recupera tutti i ristoranti in modo da assegnarli agli utenti appena creati
        $restaurants = Restaurant::all();

        // Associa ciascun utente a un ristorante
        $users->each(function ($user, $index) use ($restaurants) {
            if (isset($restaurants[$index])) {
                $restaurant = $restaurants[$index];
                $restaurant->user_id = $user->id; 
                $restaurant->save();
            }
        });
    }
}
