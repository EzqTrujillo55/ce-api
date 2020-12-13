<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contacto; 

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'organizacion' => 'required',
            'ciudad'=> 'required',
            'direccion'=> 'required',
            'identificacion'=> 'required',
            'nombre' => 'required', 
            'email' => 'required',
            'telefono' => 'required',
            'empresa_id'=> 'required' 
        ]);
        Contacto::create($validated);
        return response()->json(array('mensaje'=> 'Contacto creado exitosamente'));
    }


    public function search(Request $request){
        $parametro = $request->get('parametro');
        $contactos = array();
        if($parametro==""){
            $contactos = Contacto::with('empresa')->get(); 
        }else{
            $contactos = Contacto::with('empresa')
            ->orderBy('id', 'ASC')
            ->where('organizacion', 'LIKE', "{$parametro}%")
            ->orwhere('ciudad', 'LIKE', "{$parametro}%")
            ->orwhere('direccion', 'LIKE', "{$parametro}%")
            ->orwhere('identificacion', 'LIKE', "{$parametro}%")
            ->orwhere('nombre', 'LIKE', "{$parametro}%")
            ->orwhere('telefono', 'LIKE', "{$parametro}%")
            ->orwhere('email', 'LIKE', "{$parametro}%")
            ->orwhere('empresa_id', 'LIKE', "{$parametro}%")
            ->get();
        }

        return response()->json($contactos);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $contacto = Contacto::find($id); 
        $validated = $request->validate([
            'organizacion' => 'required',
            'ciudad'=> 'required',
            'direccion'=> 'required',
            'identificacion'=> 'required',
            'nombre' => 'required', 
            'email' => 'required',
            'telefono' => 'required',
            'empresa_id'=> 'required' 
        ]);
        $contacto->update($validated);
        return response()->json(array('mensaje'=> 'Contacto actualizado exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contacto = Contacto::find($id);
        $contacto->delete(); 
        return response()->json(['mensaje'=> 'Contacto eliminado exitosamente']); 
    }
}
