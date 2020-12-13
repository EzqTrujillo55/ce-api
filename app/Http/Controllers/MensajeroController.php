<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensajero;
class MensajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Mensajero::all());
    }

    
    public function search(Request $request){
        $parametro = $request->get('parametro');
        $mensajeros = array();
        if($parametro==""){
            $mensajeros = Mensajero::all(); 
        }else{
            $mensajeros = Mensajero::orderBy('id', 'ASC')
            ->where('cedula', 'LIKE', "{$parametro}%")
            ->orwhere('nombre', 'LIKE', "{$parametro}%")
            ->orwhere('apellido', 'LIKE', "{$parametro}%")
            ->orwhere('email', 'LIKE', "{$parametro}%")
            ->orwhere('telefono', 'LIKE', "{$parametro}%")
            ->orwhere('tipoVehiculo', 'LIKE', "{$parametro}%")
            ->orwhere('descripcionVehiculo', 'LIKE', "{$parametro}%")
            ->orwhere('placaVehiculo', 'LIKE', "{$parametro}%")
            ->orwhere('colorVehiculo', 'LIKE', "{$parametro}%")
            ->orwhere('status', 'LIKE', "{$parametro}%")
            ->get();
        }

        return response()->json($mensajeros);
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'tipoVehiculo' => 'required',
            'descripcionVehiculo' => 'required',
            'placaVehiculo' => 'required',
            'colorVehiculo' => 'required',
            'foto' => 'required|image|dimensions:min_width=200,min_height=200', 
            'cv'=> 'required'
            ]);
            $mensajero = new Mensajero($request->all());
            $path = $request->foto->store('public/fotos');
            $mensajero->foto = $path;

            $cvPath = $request->cv->store('public/cvs');
            $mensajero->cv = $cvPath; 

            $mensajero->save();
            
            return response()->json(Mensajero::latest('id')->first());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mensajero = Mensajero::find($id);
        return response()->json($mensajero);
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
       
        $request->validate([
            'cedula' => 'required',
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'tipoVehiculo' => 'required',
            'descripcionVehiculo' => 'required',
            'placaVehiculo' => 'required',
            'colorVehiculo' => 'required',
            'foto' => 'required|image|dimensions:min_width=200,min_height=200', 
            'cv'=> 'required'
            ]);
        $mensajero = Mensajero::where('id', $id)->first();

        $path = $request->foto->store('public/fotos');
        $mensajero->foto = $path; 
        $cvPath = $request->cv->store('public/cvs');
        $mensajero->cv = $cvPath; 
        $mensajero->update();
        return response()->json(['mensaje'=> 'editado exitosamente']);

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mensajero = Mensajero::find($id);
        $mensajero->delete();
        return response()->json(['mensaje'=> 'Mensajero eliminado exitosamente']);
    }
}
