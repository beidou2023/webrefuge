<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdoptionrequestSeeder extends Seeder
{
    public function run()
    {
        DB::table('adoptionrequests')->insert([
            [
                'idUser' => 4, // CARLOS RAMIREZ
                'imgUrl' => 'images/users/CR4.jpg',
                'reason' => 'ME ENCANTAN LOS ANIMALES Y QUIERO AYUDAR',
                'experience' => 'HE TENIDO HAMSTERS Y CUYES',
                'quantityExpected' => 2,
                'couple' => 1, // sí
                'aprovedBy' => 1,
                'contactTravel' => 'WHATSAPP 71234567',
                'contactReturn' => 'LLAMADA TELEFÓNICA',
                'noReturn' => 1, // no
                'care' => 0, // sí
                'followUp' => 0, // sí
                'hasPets' => 1, // no
                'petsInfo' => null,
                'canPayVet' => 0, // sí
                'status' => 1, // aceptado
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUser' => 5, // ANA FERNANDEZ
                'imgUrl' => 'images/users/AF5.jpg',
                'reason' => 'QUIERO DARLES UN HOGAR TEMPORAL',
                'experience' => 'NINGUNA, PERO HE LEÍDO MUCHO',
                'quantityExpected' => 1,
                'couple' => 2, // no
                'aprovedBy' => null,
                'contactTravel' => 'CORREO ELECTRÓNICO',
                'contactReturn' => 'WHATSAPP',
                'noReturn' => 1, // no
                'care' => 0, // sí
                'followUp' => 0, // sí
                'hasPets' => 0, // sí
                'petsInfo' => '1 PERRO MEDIANO, MUY TRANQUILO',
                'canPayVet' => 1, // no
                'status' => 2, // pendiente
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
