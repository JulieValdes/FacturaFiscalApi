<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController; 
use App\Http\Controllers\UsuariosEmpresasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1.0')->group(function () {

    /*------------------Rutas de Empresa --------------------- */
    Route::get('empresas', [EmpresaController::class, 'index']);

    Route::get('empresas/{id}', [EmpresaController::class, 'show']);    

    Route::post('empresas', [EmpresaController::class, 'create']);

    Route::put('empresas/{id}', [EmpresaController::class, 'update']);

    Route::delete('empresas/{id}', [EmpresaController::class, 'delete']);

    Route::get('empresas/{id}/usuarios', [EmpresaController::class, 'UsuariosPorEmpresa']);

    /*------------------Rutas de Usuario --------------------- */
    Route::get('usuarios', [UsuarioController::class, 'index']);

    Route::get('usuarios/{id}', [UsuarioController::class, 'show']);

    Route::post('usuarios', [UsuarioController::class, 'create']);

    Route::put('usuarios/{id}', [UsuarioController::class, 'update']);

    Route::delete('usuarios/{id}', [UsuarioController::class, 'delete']);

    /*------------------Rutas Usuario-Empresa---------------------------- */

    Route::get('usuarios-empresas', [UsuariosEmpresasController::class, 'index']);

    Route::post('usuarios-empresas', [UsuariosEmpresasController::class, 'create']);

    Route::delete('usuarios-empresas', [UsuariosEmpresasController::class, 'delete']);
});
