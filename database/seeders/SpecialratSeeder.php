<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialratSeeder extends Seeder
{
    public function run()
    {
        DB::table('specialrats')->insert([
            [
                'idRefuge' => 1,
                'name' => 'BOLITA',
                'description' => 'RATITA CIEGA QUE SE ORIENTA POR EL OÍDO. MUY TRANQUILA Y CARIÑOSA.',
                'sex' => 'F',
                'imgUrl' => 'images/example.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idRefuge' => 1,
                'name' => 'CHISPA',
                'description' => 'TIENE UNA PATA TRASERA AMPUTADA. MUY ACTIVA A PESAR DE TODO.',
                'sex' => 'M',
                'imgUrl' => 'images/example.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idRefuge' => 2,
                'name' => 'LUNITA',
                'description' => 'TIENE PROBLEMAS NEUROLÓGICOS PERO SE ADAPTA BIEN. REQUIERE SEGUIMIENTO.',
                'sex' => 'F',
                'imgUrl' => 'images/example.jpg',
                'status' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
