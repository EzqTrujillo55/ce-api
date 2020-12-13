<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contacto;
use App\Models\User; 
class Empresa extends Model
{
    use HasFactory;

    protected $fillable = ['prefijo', 'nombre', 'nombreResponsable', 'apellidoResponsable', 'email', 'telefono', 'status'];

    public function contactos(){
        return $this->hasMany(Contacto::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }

}
