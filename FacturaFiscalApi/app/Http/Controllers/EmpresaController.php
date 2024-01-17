<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('k_empresa', 'DESC')->limit(50)->get();


        return response()->json([
            'message' => 'Lista de empresas',
            'data' => $empresas,
            'status' => '200'
        ], 200);
    }

    
    public function create(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'mis_datos_nombre' => 'required',
            'mis_datos_razon_social' => 'required',
            'mis_datos_rfc' => 'required',
            'mis_datos_calle' => 'required',
            'mis_datos_no_ext' => 'required',
            'mis_datos_colonia' => 'required',
            'mis_datos_localidad' => 'required',
            'mis_datos_municipio' => 'required',
            'mis_datos_estado' => 'required',
            'mis_datos_pais' => 'required',
            'mis_datos_cp' => 'required',
            'mis_datos_regimen' => 'required',
            'mis_datos_email' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }
        
        $ultimoKEmpresa = Empresa::max('k_empresa');
        $empresa = new Empresa();
        $id = $ultimoKEmpresa + 1;
        $empresa->k_empresa = $ultimoKEmpresa + 1;
        $empresa->fill($request->all());
        if($empresa->save()){
            $empresa = Empresa::find($id);
            return response()->json([
                'message' => 'Empresa creada correctamente',
                'data' =>  $empresa,
                'status' => 201
            ], 201);
        }

        return response()->json([
            'message' => 'Empresa no creada',
            'data' => $empresa,
            'status' => '500'
        ], 500);
        
    }
    
    public function show($id)
    {
        $empresa = Empresa::find($id);

        if ($empresa) {
            return response()->json([
                'message' => 'Empresa encontrada',
                'data' => $empresa,
                'status' => '200'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Empresa no encontrada',
                'status' => '404'
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'mis_datos_nombre' => 'required',
            'mis_datos_razon_social' => 'required',
            'mis_datos_rfc' => 'required',
            'mis_datos_calle' => 'required',
            'mis_datos_no_ext' => 'required',
            'mis_datos_colonia' => 'required',
            'mis_datos_localidad' => 'required',
            'mis_datos_municipio' => 'required',
            'mis_datos_estado' => 'required',
            'mis_datos_pais' => 'required',
            'mis_datos_cp' => 'required',
            'mis_datos_regimen' => 'required',
            'mis_datos_email' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }
        
        $empresa = Empresa::find($id);
        if($empresa){
            $empresa->fill($request->all());
            $empresa->save();
            if($empresa->save()){
            return response()->json([
                'message' => 'Empresa actualizada correctamente',
                'data' => $empresa,
                'status' => '200'
            ], 200);
            }
            return response()->json([
                'message' => 'Empresa no actualizada',
                'data' => $empresa,
                'status' => '500'
            ], 500);
        }
        return response()->json([
            'message' => 'Empresa no encontrada',
            'data' => $empresa,
            'status' => '500'
        ], 500);

    }
    
    public function delete($id)
    {
        $empresa = Empresa::find($id);
        if($empresa){
            $empresa->delete();
            return response()->json([
                'message' => 'Empresa eliminada correctamente',
                'data' => $empresa,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Empresa no eliminada',
            'data' => $empresa,
            'status' => '500'
        ], 500);
    }
        
    public function UsuariosPorEmpresa($id)
    {
        $usuarios = DB::table('usrs_empresas')
        ->join('usrs', 'usrs_empresas.k_user', '=', 'usrs.k_user')
        ->where('usrs_empresas.k_empresa', '=', $id)
        ->select('usrs.*')
        ->get();

        if ($usuarios) {
            return response()->json([
                'message' => 'Usuarios encontrados',
                'data' => $usuarios,
                'status' => '200'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Usuarios no encontradas',
                'status' => '404'
            ], 404);
        }
    }
}
