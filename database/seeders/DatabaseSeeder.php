<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RefugeSeeder::class,
            SpecialratSeeder::class,
            AdoptionrequestSeeder::class,
            ArrivalSeeder::class,
            AdoptiondeliverySeeder::class,
            RatSeeder::class,
            RatreportSeeder::class,
        ]);
    }
}
