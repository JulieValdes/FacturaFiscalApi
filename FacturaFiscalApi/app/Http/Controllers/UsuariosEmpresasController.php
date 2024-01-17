<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UsuarioEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class UsuariosEmpresasController extends Controller
{
    public function index(){
        $usuariosEmpresas = UsuarioEmpresa::orderBy('k_empresa', 'DESC')->limit(50)->get();
        return response()->json([
            'message' => 'Lista de usuarios empresas',
            'data' => $usuariosEmpresas,
            'status' => '200'
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'k_user' => 'required',
            'k_empresa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }
        
        $usuarioEmpresa = new UsuarioEmpresa();
        $usuarioEmpresa->fill($request->all());
        if($usuarioEmpresa->save()){
            $usuarioEmpresa = UsuarioEmpresa::where('k_empresa', $request->k_empresa) ->where('k_user', $request->k_user)->first();
            return response()->json([
                'message' => 'Usuario empresa creado',
                'data' => $usuarioEmpresa,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear usuario empresa',
            'status' => '400'
        ], 400);
        
    }

    //No se puede hacer un delete adecuado sin una llave primaria en la tabla de relación
    //laravel presupone que hay una llave primaria y trabaja sus consultas en base a eso
    public function delete(Int $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k_user' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        } 
        $usuarioEmpresa = UsuarioEmpresa::where('k_empresa', $id) ->where('k_user', $request->k_user)->first();

        $result = UsuarioEmpresa::where('k_empresa', $id) ->where('k_user', $request->k_user)->delete();

        if ($result) {

           
            
            return response()->json([
                'message' => 'Usuario empresa eliminado',
                'data' => $usuarioEmpresa,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Usuario empresa no encontrado o no eliminado',
            'status' => '404'
        ], 404);
    }

}
