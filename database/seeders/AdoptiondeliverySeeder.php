<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdoptiondeliverySeeder extends Seeder
{
    public function run()
    {
        DB::table('adoptiondeliveries')->insert([
            [
                'deliveredBy' => 2, // JAVIER PEREZ
                'idAdoptionrequest' => 1, // solicitud de CARLOS
                'maleCount' => 1,
                'femaleCount' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'deliveredBy' => 3, // LUCIA MARTINEZ
                'idAdoptionrequest' => 2, // solicitud de ANA
                'maleCount' => 0,
                'femaleCount' => 2, // corregido a mínimo permitido
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
