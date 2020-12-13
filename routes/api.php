<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MensajeroController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\OrdenController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::post('mensajeros/search', [MensajeroController::class, 'search']);
Route::apiResource('mensajeros', MensajeroController::class);
Route::post('rutas/search', [RutaController::class, 'search']);
Route::apiResource('rutas', RutaController::class);
Route::post('cargaMasiva', [OrdenController::class, 'import']); 
Route::post('ordenes/search', [OrdenController::class, 'search']);
Route::post('ordenes/asignar/{id}', [OrdenController::class, 'asignarOrdenARuta']);
Route::apiResource('ordenes', OrdenController::class);
Route::post('empresas/search', [EmpresaController::class, 'search']);
Route::apiResource('empresas' , EmpresaController::class); 
Route::post('contactos/search', [ContactoController::class, 'search']);
Route::apiResource('contactos' , ContactoController::class); 
Route::apiResource('admins', AdminController::class); 