<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UsuarioEmpresa;
use Illuminate\Support\Facades\DB;

class UsuariosEmpresasController extends Controller
{
    public function index(){
        $usuariosEmpresas = UsuarioEmpresa::orderBy('k_empresa', 'ASC')->limit(50)->get();
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

    public function delete(Request $request){ 
        //Se puede recibir por el path o en un json es mejor opción?
        //DB::table('usrs_empresas')-$requesthere('k_user', $k_user)->where('k_empresa', $k_empresa)->delete();
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

        $usuarioEmpresa = UsuarioEmpresa::where('k_user', $request->k_user)->where('k_empresa', $request->k_empresa)->first();
        if(!$usuarioEmpresa){
            return response()->json([
                'message' => 'No se encontró la relación',
                'status' => '400'
            ], 400);
        }

        $usuarioEmpresa->delete();

        return response()->json([
            'message' => 'Relación eliminada correctamente',
            'status' => '200'
        ], 200);
    }   
}
