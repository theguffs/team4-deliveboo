<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Italiano',
                       'Internazionale',
                       'Cinese',
                       'Giapponese',
                       'Messicano',
                       'Indiano',
                       'Pesce',
                       'Carne',
                       'Pizza'];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
