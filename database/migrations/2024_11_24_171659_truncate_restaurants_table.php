<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TruncateRestaurantsTable extends Migration
{
    public function up()
    {
        // Disabilita temporaneamente i foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Truncate della tabella restaurants
        DB::table('restaurants')->truncate();

        // Riabilita i foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down()
    {
        
        
    }
}