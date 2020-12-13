<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mensajero;
class MensajerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Mensajero::truncate(); 
        $faker = \Faker\Factory::create();
        for($i=0; $i<20; $i++){
            Mensajero::create([
                'cedula' => $faker->sentence,
                'nombre' => $faker->sentence,
                'apellido' => $faker->sentence, 
                'email' => $faker->sentence . '@gmail.com',
                'telefono' => '0998131420', 
                'tipoVehiculo' => $faker->sentence,
                'descripcionVehiculo' => $faker->sentence,
                'placaVehiculo' => $faker->sentence,
                'colorVehiculo' => $faker->sentence,
                'status'=> 'C' 
            ]);
        }
    }
}
