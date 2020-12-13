<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruta;
class Mensajero extends Model
{
    use HasFactory;

    protected $fillable= ['cedula', 'nombre', 'apellido', 'email', 'telefono', 'tipoVehiculo', 'descripcionVehiculo', 'placaVehiculo', 'colorVehiculo', 'status', 'foto']; 

    public function rutas(){
        return $this->hasMany(Ruta::class);
    }

}
