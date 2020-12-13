<?php

namespace App\Imports;

use App\Models\Orden;
use App\Models\Empresa; 
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class OrdenesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Orden|null
     */
    public function model(array $row)
    {
        $empresa = request()->get('empresa'); 
        $prefijoEmpresa = Empresa::where('nombre', $empresa)->get()->toArray();
        $ordenesxempresa= Orden::where('empresa', $empresa)->get(); 
        $cuentaOxE = count($ordenesxempresa);
        $siguienteCodigo = str_pad($cuentaOxE+1, 4, '0', STR_PAD_LEFT);
        $codigoOrden = $prefijoEmpresa[0]['prefijo'] . $siguienteCodigo;

        return new Orden([
           'empresa'     => $empresa,
           'tipoServicio' => $row['tiposervicio'], 
           'peso' => $row['peso'],
           'numGestiones' => $row['gestiones'],
           'origen' => $row['origen'],
           'ciudadOrigen' => $row['corigen'],
           'dirOrigen' => $row['dorigen'], 
           'remitente' => $row['remitente'],
           'telRemitente' => $row['tremitente'],
           'destino' => $row['destino'],
           'ciudadDestino' => $row['cdestino'],
           'dirDestino' => $row['ddestino'], 
           'destinatario' => $row['destinatario'],
           'telDestinatario' => $row['tdestinatario'],
           'detalle' => $row['detalle'],
           'codigo' => $codigoOrden, 
           'status' => 'Nuevo' 
        ]);
    }
}