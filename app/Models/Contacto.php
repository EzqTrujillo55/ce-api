<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa; 


class Contacto extends Model
{
    use HasFactory;


    protected $fillable = ['organizacion', 'ciudad', 'direccion', 'identificacion', 'nombre', 'telefono', 'email', 'empresa_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
