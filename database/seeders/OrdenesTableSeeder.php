<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Orden;
use App\Models\Mensajero;
use App\Models\Ruta;
class OrdenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orden::truncate();
        $mensajeros = Mensajero::all();
        $rutas = Ruta::all(); 
        $faker = \Faker\Factory::create();
        for($i=0; $i<5; $i++){
            Orden::create([
                'empresa' => $faker->sentence,
                'tipoServicio' => 'Envío Express',
                'peso' => 2.5, 
                'numGestiones' => 2,
                'origen' => '0998131420', 
                'ciudadOrigen' => 'Quito',
                'dirOrigen' => $faker->sentence,
                'remitente' => $faker->sentence,
                'telRemitente' => $faker->sentence,
                'destino'=> 'C',
                'ciudadDestino' => 'Guayaquil', 
                'dirDestino' => $faker->sentence,
                'destinatario' => $faker->sentence, 
                'telDestinatario' => $faker->sentence,
                'detalle' => $faker->sentence,
                'mensajero_id' =>$mensajeros[$i]->id, 
                'ruta_id' =>   $rutas[$i]->id
            ]);
        }
    }
}
