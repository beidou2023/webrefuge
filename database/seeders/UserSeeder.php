<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'firstName' => 'MARIA',
            'lastName' => 'GONZALES',
            'email' => 'a@a',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'AV. LIBERTADOR 123',
            'role' => 3,
            'status' => 1,
        ]);

        User::create([
            'firstName' => 'JAVIER',
            'lastName' => 'PEREZ',
            'email' => 'b@b',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'AV. 16 DE JULIO',
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'firstName' => 'LUCIA',
            'lastName' => 'MARTINEZ',
            'email' => 'b@b',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'CALLE SAN MARTIN',
            'role' => 2,
            'status' => 1,
        ]);

        User::create([
            'firstName' => 'CARLOS',
            'lastName' => 'RAMIREZ',
            'email' => 'c@c',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'Av. Petrolera',
            'role' => 1,
            'status' => 1,
        ]);

        User::create([
            'firstName' => 'ANA',
            'lastName' => 'FERNANDEZ',
            'email' => 'c@c',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'AV. SANTA CRUZ',
            'role' => 1,
            'status' => 2,
        ]);

        User::create([
            'firstName' => 'DIEGO',
            'lastName' => 'LOPEZ',
            'email' => 'c@c',
            'password' => Hash::make('123'),
            'phone' => '7777777',
            'address' => 'CALLE BENI',
            'role' => 1,
            'status' => 3,
        ]);
    }
}
