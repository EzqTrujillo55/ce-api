<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ruta;
use App\Models\Mensajero;
class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $rutas = Ruta::with('mensajero')->get();
        
        /*$rutas_mensajero = array();
        $mensajero = '';
        $numRutas = count($rutas);
        for($i=0; $i<$numRutas; $i++){
            $mensajero = Mensajero::find($rutas[$i]->mensajero_id)->nombre;
            $rutas[$i]['mensajero_id'] = $mensajero;
        }*/
        return response()->json($rutas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'status'=> 'required',
            'mensajero_id' => 'required' 
        ]);
        Ruta::create($validated);
        return response()->json(array('mensaje'=> 'Ruta creada exitosamente'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $rutas = array(); 
        $mensajero = $request->get('mensajero');
        $palabraClave = $request->get('palabraClave');
        $estado = $request->get('estado'); 
        
        if($mensajero=="" && $palabraClave=="" && $estado==""){
            $rutas = Ruta::with('mensajero')->get();
        }
        else
        {
            if($mensajero!=""){
                $rutas = Ruta::with('mensajero')
                ->where('mensajero_id', $mensajero)
                ->get();
            }

            if($palabraClave!=""){
                $rutas = Ruta::with('mensajero')
                ->where('detalle', 'LIKE', "%{$palabraClave}%")
                ->get();
            }

            if($estado!=""){
                $rutas = Ruta::with('mensajero')
                ->where('status', $estado)
                ->get();
            }

            if($mensajero!="" && $palabraClave!=""){
                $rutas = Ruta::with('mensajero')
                ->where('mensajero_id', $mensajero)
                ->where('detalle', 'LIKE', "%{$palabraClave}%")
                ->get();
            }

            if($mensajero!="" && $estado!=""){
                $rutas = Ruta::with('mensajero')
                ->where('mensajero_id', $mensajero)
                ->where('status', $estado)
                ->get();
            }

            if($estado!="" && $palabraClave!=""){
                $rutas = Ruta::with('mensajero')
                ->where('status', $estado)
                ->where('detalle', 'LIKE', "%{$palabraClave}%")
                ->get();
            }

            if($mensajero!="" && $palabraClave!="" && $estado!=""){
                $rutas = Ruta::with('mensajero')
                ->where('mensajero_id', $mensajero)
                ->where('detalle', 'LIKE', "%{$palabraClave}%")
                ->where('status', $estado)
                ->get();
            }
        }
        return response()->json($rutas);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ruta = Ruta::with('mensajero')->where('id', $id)->get(); 
        return response()->json($ruta);
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
        $ruta = Ruta::find($id);
        $validated = $request->validate([
            'status'=> 'required',
            'mensajero_id' => 'required' 
        ]);
        $ruta->update($validated);
        return response()->json(['mensaje'=> 'Ruta editada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruta = Ruta::find($id);
        $ruta->delete();
        return response()->json(['mensaje'=> 'Ruta eliminada exitosamente']);
    }
}


