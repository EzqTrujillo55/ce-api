<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orden; 
use App\Models\Empresa; 
use App\Models\Mensajero; 
use App\Imports\OrdenesImport;
use Maatwebsite\Excel\Facades\Excel;
class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $ordenes = Orden::with('ruta')->get();
        /*$rutas_mensajero = array();
        $mensajero = '';
        $numRutas = count($rutas);
        for($i=0; $i<$numRutas; $i++){
            $mensajero = Mensajero::find($rutas[$i]->mensajero_id)->nombre;
            $rutas[$i]['mensajero_id'] = $mensajero;
        }*/
        return response()->json($ordenes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$validated = $request->validate([
            'status'=> 'required',
            'detalle' => 'required',  
        ]);*/
        
        $empresa = $request->get('empresa'); 
        $tipoServicio = $request->get('tipoServicio');
        $peso = $request->get('peso');
        $numGestiones = $request->get('numGestiones');
        $origen = $request->get('origen');
        $ciudadOrigen = $request->get('ciudadOrigen');
        $dirOrigen = $request->get('dirOrigen');
        $remitente = $request->get('remitente');
        $telRemitente = $request->get('telRemitente');
        $destino = $request->get('destino');
        $ciudadDestino = $request->get('ciudadDestino'); 
        $dirDestino = $request->get('dirDestino');
        $destinatario = $request->get('destinatario');
        $telDestinatario = $request->get('telDestinatario'); 
        $detalle = $request->get('detalle');
        $ruta = $request->get('ruta_id');
        $status = 'Nuevo';
        $prefijoEmpresa = Empresa::where('nombre', $empresa)->get()->toArray();
        $ordenesxempresa= Orden::where('empresa', $empresa)->get(); 
        $cuentaOxE = count($ordenesxempresa);
        $siguienteCodigo = str_pad($cuentaOxE+1, 4, '0', STR_PAD_LEFT);
        $codigoOrden = $prefijoEmpresa[0]['prefijo'] . $siguienteCodigo;  
        $datos = array(
        'codigo' => $codigoOrden, 
        'empresa' => $empresa, 
        'tipoServicio' => $tipoServicio, 
        'peso' => $peso, 
        'numGestiones' => $numGestiones,
        'origen' => $origen,
        'ciudadOrigen' => $ciudadOrigen,
        'dirOrigen' => $dirOrigen,
        'remitente' => $remitente,
        'telRemitente' => $telRemitente,
        'destino' => $destino,
        'ciudadDestino' => $ciudadDestino,
        'dirDestino' => $dirDestino,
        'destinatario' => $destinatario,
        'telDestinatario' => $telDestinatario,
        'detalle' => $detalle,
        /*'mensajero_id' => $mensajero,
        'ruta_id' => $ruta,*/
        'status' => $status
        );
        Orden::create($datos);
        return response()->json(array('mensaje'=> 'Orden creada exitosamente'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $ordenes = array(); 
        $palabraClave = $request->get('palabraClave');
        $codigo = $request->get('codigo');
        $ruta = $request->get('ruta_id');
        $empresa = $request->get('empresa');
        $tipoServicio = $request->get('tipoServicio');
        $estado = $request->get('estado');

        if($palabraClave=="" && $codigo=="" && $ruta=="" && $empresa=="" && $tipoServicio=="" && $estado==""){
            $ordenes = Orden::with('ruta.mensajero')->orderBy('id', 'DESC')->get();
        }
        else
        { 
            $condiciones = array(); 
            if($palabraClave!=""){
                array_push($condiciones, array('detalle', 'LIKE', "%{$palabraClave}%"));
            }

            if($codigo!=""){
                array_push($condiciones, array('codigo', $codigo));
            }

            if($ruta!=""){
                array_push($condiciones, array('ruta_id', $ruta));
            }

            if($empresa!=""){
                array_push($condiciones, array('empresa', $empresa));
            }

            if($tipoServicio!=""){
                array_push($condiciones, array('tipoServicio', $tipoServicio));
            }

            if($estado!=""){
                array_push($condiciones, array('status', $estado));
            }


            if($palabraClave!="" && $codigo!=""){
                array_push($condiciones, array('detalle',  'LIKE', "%{$palabraClave}%"));
                array_push($condiciones, array('codigo', $codigo));
            }

            if($palabraClave!="" && $ruta!=""){
                array_push($condiciones, array('detalle', 'LIKE', "%{$palabraClave}%"));
                array_push($condiciones, array('ruta_id',$ruta));
            }

            if($palabraClave!="" && $empresa!=""){
                array_push($condiciones, array('detalle', 'LIKE', "%{$palabraClave}%"));
                array_push($condiciones, array('empresa',$empresa));
            }

            if($palabraClave!="" && $tipoServicio!=""){
                array_push($condiciones, array('detalle', 'LIKE', "%{$palabraClave}%"));
                array_push($condiciones, array('tipoServicio',$tipoServicio));
            }

            if($palabraClave!="" && $estado!=""){
                array_push($condiciones, array('detalle', 'LIKE', "%{$palabraClave}%"));
                array_push($condiciones, array('status',$estado));
            }

            if($codigo!="" && $ruta!=""){
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('ruta_id',$ruta));
            }

            if($codigo!="" && $empresa!=""){
                array_push($condiciones, array('codigo', $codigo ));
                array_push($condiciones, array('empresa',$empresa));
            }

            if($codigo!="" && $tipoServicio!=""){
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('tipoServicio',$tipoServicio));
            }

            if($codigo!="" && $estado!=""){
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('status', $estado));
            }

            if($ruta!="" && $empresa!=""){
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('empresa', $empresa));
            }

            if($ruta!="" && $tipoServicio!=""){
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('tipoServicio', $tipoServicio));
            }

            if($ruta!="" && $estado!=""){
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('status', $estado));
            }

            if($empresa!="" && $tipoServicio!=""){
                array_push($condiciones, array('empresa', $empresa));
                array_push($condiciones, array('tipoServicio', $tipoServicio));
            }

            if($empresa!="" && $estado!=""){
                array_push($condiciones, array('empresa', $empresa));
                array_push($condiciones, array('status', $estado));
            }
           
            if($palabraClave!="" && $codigo!="" && $ruta!=""){
                array_push($condiciones, array('detalle',  'LIKE', "%{$palabraClave}%")); 
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('ruta_id', $ruta));
            }

            if($empresa!="" && $tipoServicio!="" && $estado!=""){
                array_push($condiciones, array('empresa', $empresa)); 
                array_push($condiciones, array('tipoServicio', $tipoServicio));
                array_push($condiciones, array('status', $estado));
            }

            if($palabraClave!="" && $codigo!="" && $ruta!="" && $empresa!=""){
                array_push($condiciones, array('detalle',  'LIKE', "%{$palabraClave}%")); 
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('empresa', $empresa));
            }

            if($palabraClave!="" && $codigo!="" && $ruta!="" && $empresa!="" && $tipoServicio!=""){
                array_push($condiciones, array('detalle',  'LIKE', "%{$palabraClave}%")); 
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('empresa', $empresa));
                array_push($condiciones, array('tipoServicio', $tipoServicio));
            }

            if($palabraClave!="" && $codigo!="" && $ruta!="" && $empresa!="" && $tipoServicio!="" && $estado!=""){
                array_push($condiciones, array('detalle',  'LIKE', "%{$palabraClave}%")); 
                array_push($condiciones, array('codigo', $codigo));
                array_push($condiciones, array('ruta_id', $ruta));
                array_push($condiciones, array('empresa', $empresa));
                array_push($condiciones, array('tipoServicio', $tipoServicio));
                array_push($condiciones, array('status', $estado));
            }
            $ordenes = Orden::with('ruta.mensajero')->orderBy('id', 'DESC')->where($condiciones)->get(); 
        }
        return response()->json($ordenes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orden = Orden::with('ruta.mensajero')->where('id', $id)->get(); 
        return response()->json($orden);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orden = Orden::find($id);
        $empresa = $request->get('empresa'); 
        $tipoServicio = $request->get('tipoServicio');
        $peso = $request->get('peso');
        $numGestiones = $request->get('numGestiones');
        $origen = $request->get('origen');
        $ciudadOrigen = $request->get('ciudadOrigen');
        $dirOrigen = $request->get('dirOrigen');
        $remitente = $request->get('remitente');
        $telRemitente = $request->get('telRemitente');
        $destino = $request->get('destino');
        $ciudadDestino = $request->get('ciudadDestino'); 
        $dirDestino = $request->get('dirDestino');
        $destinatario = $request->get('destinatario');
        $telDestinatario = $request->get('telDestinatario'); 
        $detalle = $request->get('detalle');
        $ruta = $request->get('ruta_id');
        $status = $request->get('status');
        if($orden->empresa != $empresa){
            $prefijoEmpresa = Empresa::where('nombre', $empresa)->get()->toArray();
            $ordenesxempresa= Orden::where('empresa', $empresa)->get(); 
            $cuentaOxE = count($ordenesxempresa);
            $siguienteCodigo = str_pad($cuentaOxE+1, 4, '0', STR_PAD_LEFT);
            $codigoOrden = $prefijoEmpresa[0]['prefijo'] . $siguienteCodigo;
        }else{
            $codigoOrden = $orden->codigo; 
        }

        $datos = array(
        'codigo' => $codigoOrden, 
        'empresa' => $empresa, 
        'tipoServicio' => $tipoServicio, 
        'peso' => $peso, 
        'numGestiones' => $numGestiones,
        'origen' => $origen,
        'ciudadOrigen' => $ciudadOrigen,
        'dirOrigen' => $dirOrigen,
        'remitente' => $remitente,
        'telRemitente' => $telRemitente,
        'destino' => $destino,
        'ciudadDestino' => $ciudadDestino,
        'dirDestino' => $dirDestino,
        'destinatario' => $destinatario,
        'telDestinatario' => $telDestinatario,
        'detalle' => $detalle,
        /*'mensajero_id' => $mensajero,
        'ruta_id' => $ruta,*/
        'status' => $status
        );
        $orden->update($datos);
        return response()->json(array('mensaje'=> 'Orden editada exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orden = Orden::find($id);
        $orden->delete();
        return response()->json(['mensaje'=> 'Orden eliminada exitosamente']);
    }

    public function asignarOrdenARuta($id, Request $request){
        $orden = Orden::find($id); 
        $datos = array('ruta_id' => $request->get('ruta_id'));
        $orden->update($datos);
        return response()->json(array('mensaje'=> 'Orden asignada exitosamente'));
    }

    public function import() 
    {
        Excel::import(new OrdenesImport, request()->file('formato'));
        //Excel::import(new OrdenesImport, 'ordenes.xlsx');
        //return redirect('/')->with('success', 'All good!');
        return response()->json(['estado'=> true]);
    }




  
}
