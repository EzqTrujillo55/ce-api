<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ruta;
use App\Models\Mensajero;
class Orden extends Model
{
    use HasFactory;
    protected $fillable = ['empresa', 'tipoServicio', 'peso', 'numGestiones', 'origen', 'ciudadOrigen', 'dirOrigen', 'remitente', 'telRemitente', 'destino', 'ciudadDestino', 'dirDestino', 'destinatario', 'telDestinatario', 'detalle', 'mensajero_id', 'ruta_id', 'codigo', 'status'];
    protected $table = 'Ordenes';

    public function ruta(){
        return $this->belongsTo(Ruta::class);
    }

    
}
