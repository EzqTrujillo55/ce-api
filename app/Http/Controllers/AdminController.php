<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminController extends Controller
{

    public function index()
    {
        $admins = Admin::all(); 
        return response()->json($admins);
    }

    public function store(Request $request)
    {
        //Validación de todos los campos 
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'status' => 'required', 
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        //Una vez validados los campos se crea el administrador con los campos
        //de su tabla 
        $admin = Admin::create([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'telefono' => $request->get('telefono'),
            'status' => $request->get('status'),
        ]);

        //Obtenemos el admin creado para luego usar su id
        $adminCreado = Admin::latest()->first();
        //Creamos el usuario con los campos de email, password y el id del admin 
        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'admin_id' => $adminCreado['id']
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(array('mensaje'=> 'Admin creado exitosamente'));
    }
}
