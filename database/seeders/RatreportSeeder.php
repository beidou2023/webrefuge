<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatreportSeeder extends Seeder
{
    public function run()
    {
        DB::table('ratreports')->insert([
            [
                'idUser' => 4, // CARLOS RAMIREZ
                'idRat' => 1,
                'reviewedBy' => 5, // ANA FERNANDEZ
                'comment' => 'La rata está saludable, sin problemas visibles.',
                'resolved' => 0, // sí resuelto
                'status' => 1, // buena salud
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUser' => 5, // ANA FERNANDEZ
                'idRat' => 2,
                'reviewedBy' => 6, // DIEGO LOPEZ
                'comment' => 'Presenta signos leves de enfermedad, en observación.',
                'resolved' => 1, // no resuelto
                'status' => 2, // enferma
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUser' => 6, // DIEGO LOPEZ
                'idRat' => 3,
                'reviewedBy' => null,
                'comment' => 'Se reportó como perdida, buscando activamente.',
                'resolved' => 0,
                'status' => 3, // perdida
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
