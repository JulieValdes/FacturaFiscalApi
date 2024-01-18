<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\UsuarioController; 
use App\Http\Controllers\UsuariosEmpresasController;
use App\Http\Controllers\SujetoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaProductoController;

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

    Route::delete('usuarios-empresas/{id}', [UsuariosEmpresasController::class, 'delete']);

    /*------------------Rutas de Sujeto --------------------- */

    Route::get('sujetos', [SujetoController::class, 'index']);

    Route::post('sujetos', [SujetoController::class, 'create']);

    Route::get('sujetos/{id}', [SujetoController::class, 'show']);

    Route::put('sujetos/{id}', [SujetoController::class, 'update']);

    Route::delete('sujetos/{id}', [SujetoController::class, 'delete']);

    /*------------------Rutas de Venta--------------------------- */

    Route::get('ventas', [VentaController::class, 'index']);

    Route::post('ventas', [VentaController::class, 'create']);

    Route::get('ventas/{id}', [VentaController::class, 'show']);

    Route::delete('ventas/{id}', [VentaController::class, 'delete']);

    Route::put('ventas/{id}', [VentaController::class, 'update']);

    /*------------------Rutas de Articulos--------------------------- */
    
    Route::get('articulos', [ProductoController::class, 'index']);

    Route::post('articulos', [ProductoController::class, 'create']);

    Route::get('articulos/{id}', [ProductoController::class, 'show']);

    Route::put('articulos/{id}', [ProductoController::class, 'update']);

    Route::delete('articulos/{id}', [ProductoController::class, 'delete']);

    /*------------------Rutas de Venta-Producto--------------------------- */
    Route::get('ventas-productos', [VentaProductoController::class, 'index']);

    Route::post('ventas-productos', [VentaProductoController::class, 'create']);

    Route::get('ventas-productos/{id}', [VentaProductoController::class, 'show']);

    Route::put('ventas-productos/{id}', [VentaProductoController::class, 'update']);

    Route::delete('ventas-productos/{id}', [VentaProductoController::class, 'delete']);
});
