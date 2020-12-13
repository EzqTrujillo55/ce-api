<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::all();
        return response()->json($empresas);
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
            'prefijo' => 'required',
            'nombre'=> 'required',
            'nombreResponsable'=> 'required',
            'apellidoResponsable'=> 'required',
            'telefono' => 'required',
            'status'=> 'required'
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        Empresa::create($validated);
        $empresaCreada = Empresa::latest()->first();

        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'empresa_id' => $empresaCreada['id']
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(array('mensaje'=> 'Empresa creada exitosamente'));
    }

    public function search(Request $request){
        $parametro = $request->get('parametro');
        $empresas = array();
        if($parametro==""){
            $empresas = Empresa::with('users')->get();
        }else{
            $empresas = Empresa::with('users')->orderBy('id', 'ASC')
            ->where('prefijo', 'LIKE', "{$parametro}%")
            ->orwhere('nombre', 'LIKE', "{$parametro}%")
            ->orwhere('apellidoResponsable', 'LIKE', "{$parametro}%")
            ->orwhere('nombreResponsable', 'LIKE', "{$parametro}%")
            ->orwhere('telefono', 'LIKE', "{$parametro}%")
            ->orwhere('email', 'LIKE', "{$parametro}%")
             ->orwhere('status', 'LIKE', "{$parametro}%")
            ->get();
        }

        return response()->json($empresas);
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
        $empresa = Empresa::find($id);
        $validated = $request->validate([
            'prefijo' => 'required',
            'nombre'=> 'required',
            'nombreResponsable'=> 'required',
            'apellidoResponsable'=> 'required',
            'telefono' => 'required',
            'status'=> 'required'
        ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
            ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $empresa->update($validated);
        //$usuarioEmpresaEditada = User::find($id);
        $user = User::find($id)
        ->update([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(array('mensaje'=> 'Empresa editada exitosamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empresa = Empresa::find($id);
        $empresa->delete();
        return response()->json(array('mensaje'=> 'Empresa eliminada exitosamente'));
    }
}
