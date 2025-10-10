<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefugeSeeder extends Seeder
{
    public function run()
    {
        DB::table('refuges')->insert([
            [
                'idManager' => 2,
                'name' => 'REFUGIO CENTRAL LA PAZ',
                'address' => 'AV. 6 DE AGOSTO, ZONA CENTRAL, LA PAZ',
                'maleCount' => 12,
                'femaleCount' => 9,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idManager' => 3,
                'name' => 'HOGAR DE RATITAS FELICES',
                'address' => 'CALLE LOS CLAVELES, ZONA SUR, COCHABAMBA',
                'maleCount' => 7,
                'femaleCount' => 15,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
