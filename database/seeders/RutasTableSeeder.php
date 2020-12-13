<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mensajero;
use App\Models\Ruta;
class RutasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Ruta::truncate();
        $mensajeros = Mensajero::all(); 
        $faker = \Faker\Factory::create();
        foreach($mensajeros as $mensajero){
            Ruta::create([
                'status'=> 'C' ,
                'detalle' => $faker->sentence,
                'mensajero_id'=> $mensajero->id 
            ]);
        }
    }
}
