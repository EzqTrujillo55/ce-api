<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mensajero; 
use App\Models\Orden; 

class Ruta extends Model
{
    use HasFactory;

    protected $fillable = ['status', 'mensajero_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function mensajero(){
        return $this->belongsTo(Mensajero::class);
    }

    public function ordenes(){
        return $this->hasMany(Orden::class);
    }
}
