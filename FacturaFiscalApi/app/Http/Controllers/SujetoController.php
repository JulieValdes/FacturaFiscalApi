<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sujeto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SujetoController extends Controller
{
    public function index(){
        $sujetos = Sujeto::orderBy('k_sujetos', 'ASC')->limit(10)->get();
        return response()->json([
            'message' => 'Lista de sujetos',
            'data' => $sujetos,
            'status' => '200'
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'sujetos_nombre' => 'required',
            'sujetos_alias' => 'required',
            'sujetos_regimen' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $sujeto = new Sujeto();
        $sujeto->fill($request->all());
        if($sujeto->save()){
            $consulta = DB::table('sujetos')->where('k_empresa', $request->k_empresa)->orderByRaw('CAST(k_sujetos AS UNSIGNED) DESC')->limit(1)->first();

            return response()->json([
                'message' => 'Sujeto creado correctamente',
                'data' => $consulta,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear sujeto',
            'status' => '400'
        ], 400);

    }

    public function show($id, Request $request){

        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        
        $sujeto = DB::table('sujetos')->where('k_sujetos', $id)->where('k_empresa', $request->k_empresa)->first();

        if($sujeto){
            return response()->json([
                'message' => 'Sujeto encontrado',
                'data' => $sujeto,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Sujeto no encontrado',
            'status' => '400'
        ], 400);
    }

    public function update(Int $id, Request $request){
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'sujetos_nombre' => 'required',
            'sujetos_alias' => 'required',
            'sujetos_regimen' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $result = Sujeto::where('k_sujetos', $id)
                ->where('k_empresa', $request->k_empresa)
                ->update($request->all());

        if ($result) {
            $sujeto = Sujeto::where('k_sujetos', $id)->where('k_empresa', $request->k_empresa)->first();

            return response()->json([
                'message' => 'Sujeto actualizado correctamente',
                'data' => $sujeto,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Sujeto no encontrado',
            'status' => '404'
        ], 404);
    }

    public function delete(Int $id, Request $request){
        
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $sujeto = Sujeto::where('k_sujetos', $id)->where('k_empresa', $request->k_empresa)->first();

        $result = Sujeto::where('k_sujetos', $id)->where('k_empresa', $request->k_empresa)->delete();

        if ($result) {

            return response()->json([
                'message' => 'Sujeto eliminado correctamente',
                'data' => $sujeto,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Sujeto no encontrado',
            'status' => '404'
        ], 404);
    }
}
