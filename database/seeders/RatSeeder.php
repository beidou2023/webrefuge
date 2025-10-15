<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatSeeder extends Seeder
{
    public function run()
    {
        DB::table('rats')->insert([
            // Entrega 1 - para CARLOS
            [
                'idAdoptiondelivery' => 1,
                'idUser' => 4,
                'name' => 'BOLITA',
                'color' => 'GRIS',
                'sex' => 'M',
                'ageMonths' => 5,
                'type' => 1,
                'adoptedAt' => now(),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'idSpecialrat' => null,
            ],
            [
                'idAdoptiondelivery' => 1,
                'idUser' => 4,
                'name' => 'LUCERITO',
                'color' => 'BLANCO',
                'sex' => 'F',
                'ageMonths' => 4,
                'type' => 1,
                'adoptedAt' => now(),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'idSpecialrat' => null,
            ],

            // Entrega 2 - para ANA
            [
                'idAdoptiondelivery' => 2,
                'idUser' => 5,
                'name' => 'NIEVE',
                'color' => 'BLANCO',
                'sex' => 'F',
                'ageMonths' => 3,
                'type' => 1,
                'adoptedAt' => now(),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'idSpecialrat' => null,
            ],
            [
                'idAdoptiondelivery' => 2,
                'idUser' => 5,
                'name' => 'CANELA',
                'color' => 'CAFÉ CLARO',
                'sex' => 'F',
                'ageMonths' => 4,
                'type' => 1,
                'adoptedAt' => now(),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'idSpecialrat' => null,
            ],
        ]);
    }
}
