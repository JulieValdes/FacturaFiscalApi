<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index(){
        $ventas = Venta::orderBy('k_venta', 'ASC')->limit(50)->get();
        return response()->json([
            'message' => 'Lista de ventas',
            'data' => $ventas,
            'status' => '200'
        ], 200);
    }


    //Problemas aumentar k_venta en base a k_empresa
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'k_sujeto' => 'required',
            //'venta_fecha' => 'required',
            'venta_subtotal' => 'required',
            'venta_iva' => 'required',
            'venta_total' => 'required',
            'venta_formapago' => 'required',
            'venta_serie' => 'required',
            'venta_tipo' => 'required',
            'venta_metodo' => 'required',
            'venta_moneda' => 'required',
            //'venta_uso_cfdi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        
        // Obtenemos el último k_venta dentro de la transacción
        $ultimoKVenta = Venta::where('k_empresa', $request->k_empresa)->max('k_venta');

        // Creamos el nuevo objeto Venta
        $venta = new Venta();
        $venta->k_venta = $ultimoKVenta ? $ultimoKVenta + 1 : 1; // Si es nulo, empezamos desde 1
        $venta->fill($request->all());
        if ($venta->save()) {
            return response()->json([
                'message' => 'Venta creada correctamente',
                'data' => $venta,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear venta',
            'data' => $venta,
            'status' => '400'
        ], 400);

    }

    public function show($id, Request $request){

        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $venta = Venta::where('k_venta', $id)->where('k_empresa', $request->k_empresa)->first();
        if ($venta) {
            return response()->json([
                'message' => 'Venta encontrada',
                'data' => $venta,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Venta no encontrada',
            'status' => '404'
        ], 404);
    }

    //es un problema que k_venta no sea autoincrementable ya que hay repetidos para una empresa y no hay manera de saber cual es el que se va a modificar
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'k_sujeto' => 'required',
            //'venta_fecha' => 'required',
            'venta_subtotal' => 'required',
            'venta_iva' => 'required',
            'venta_total' => 'required',
            'venta_formapago' => 'required',
            'venta_serie' => 'required',
            'venta_tipo' => 'required',
            'venta_metodo' => 'required',
            'venta_moneda' => 'required',
            //'venta_uso_cfdi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $venta = Venta::where('k_venta', $id)->where('k_empresa', $request->k_empresa)->first();
        if ($venta) {
            $venta->fill($request->all());
            if ($venta->save()) {
                return response()->json([
                    'message' => 'Venta actualizada correctamente',
                    'data' => $venta,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al actualizar venta',
                'data' => $venta,
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Venta no encontrada',
            'status' => '404'
        ], 404);
    }

    //se estan borrando todos los registros con el mismo k_venta
    public function delete($id, Request $request){

        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'k_sujeto' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $venta = Venta::where('k_venta', $id)->where('k_empresa', $request->k_empresa)->where('k_sujeto', $request->k_sujeto)->first();
        if ($venta) {
            if ($venta->delete()) {
                return response()->json([
                    'message' => 'Venta eliminada correctamente',
                    'data' => $venta,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al eliminar venta',
                'data' => $venta,
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Venta no encontrada',
            'status' => '404'
        ], 404);
    }
}
