<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa; 
class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for($i=0; $i<20; $i++){
            Empresa::create([
                'prefijo' => 'EM',
                'nombre' => $faker->sentence,
                'nombreResponsable' => $faker->sentence, 
                'apellidoResponsable'=> $faker->sentence, 
                'email' => $faker->sentence . '@gmail.com',
                'telefono' => '0998131420', 
                'status'=> 'C' 
            ]);
        }
    }
}
