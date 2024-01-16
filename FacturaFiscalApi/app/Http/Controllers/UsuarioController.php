<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Usuario;
use App\Models\UsuarioEmpresa;

class UsuarioController extends Controller
{
    
    public function index()
    {
        $usuarios = Usuario::orderBy('k_user', 'DESC')->limit(50)->get();
        return response()->json([
            'message' => 'Lista de empresas',
            'data' => $usuarios,
            'status' => '200'
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'nombre' => 'required',
            'pass' => 'required',
            'es_super_admin' => 'required|boolean',
            'puede_agregar_usrs' => 'required|boolean',
            'puede_cambiar_fecha' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }
        
        $ultimoKUsuario = Usuario::max('k_user');
        $usuario = new Usuario();
        $id = $ultimoKUsuario + 1;
        $usuario->k_user = $ultimoKUsuario + 1;
        $usuario->fill($request->all());
        if($usuario->save()){
            $usuario = Usuario::find($id);
            return response()->json([
                'message' => 'Usuario creado',
                'data' => $usuario,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear usuario',
            'status' => '400'
        ], 400);
        
    }

    public function show($id){
        $usuario = Usuario::find($id);
        if($usuario){
            return response()->json([
                'message' => 'Usuario encontrado',
                'data' => $usuario,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Usuario no encontrado',
            'status' => '404'
        ], 404);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'nombre' => 'required',
            'pass' => 'required',
            'es_super_admin' => 'required|boolean',
            'puede_agregar_usrs' => 'required|boolean',
            'puede_cambiar_fecha' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }
        
        $usuario = Usuario::find($id);
        if($usuario){
            $usuario->fill($request->all());
            if($usuario->save()){
                return response()->json([
                    'message' => 'Usuario actualizado',
                    'data' => $usuario,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al actualizar usuario',
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Usuario no encontrado',
            'status' => '404'
        ], 404);
    }

    public function delete($id){
        $usuario = Usuario::find($id);
        if($usuario){
            if($usuario->delete()){
                return response()->json([
                    'message' => 'Usuario eliminado',
                    'data' => $usuario,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al eliminar usuario',
                'data'  => $usuario, 
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Usuario no encontrado',
            'status' => '404'
        ], 404);
    }
}
