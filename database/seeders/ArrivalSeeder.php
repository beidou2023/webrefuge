<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArrivalSeeder extends Seeder
{
    public function run()
    {
        DB::table('arrivals')->insert([
            [
                'maleCount' => 3,
                'femaleCount' => 2,
                'origin' => 'MERCADO CENTRAL',
                'notes' => 'RATAS ENCONTRADAS CERCA DE LOS CONTENEDORES.',
                'idRefuge' => 1, // REFUGIO CENTRAL
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'maleCount' => 0,
                'femaleCount' => 5,
                'origin' => 'CASA ABANDONADA',
                'notes' => 'FUE RESCATE NOCTURNO POR VOLUNTARIOS.',
                'idRefuge' => 2, // HOGAR RATITAS
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
