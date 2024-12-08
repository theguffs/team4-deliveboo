<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdditionalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dati dei nuovi utenti
        $users = [
            [
                'user_name' => 'Francesco Nero',
                'email' => 'francesco.nero@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Giulia Blu',
                'email' => 'giulia.blu@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Luca Rosa',
                'email' => 'luca.rosa@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Martina Viola',
                'email' => 'martina.viola@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Simone Marrone',
                'email' => 'simone.marrone@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Beatrice Rossa',
                'email' => 'beatrice.rossa@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Daniele Verde',
                'email' => 'daniele.verde@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Elena Gialla',
                'email' => 'elena.gialla@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Riccardo Viola',
                'email' => 'riccardo.viola@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_name' => 'Chiara Marrone',
                'email' => 'chiara.marrone@example.com',
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Inserisce i nuovi utenti nella tabella
        DB::table('users')->insert($users);
    }
}
