<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MensajerosTableSeeder::class);
        $this->call(RutasTableSeeder::class);
        $this->call(OrdenesTableSeeder::class);
    }
}
