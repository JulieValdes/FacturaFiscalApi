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

        $ultimoKVenta = Venta::where('k_empresa', $request->k_empresa)->max('k_venta');

        // Si no hay ventas para la k_empresa dada, se asigna 1 como el valor inicial de k_venta
        $nuevoKVenta = $ultimoKVenta ? $ultimoKVenta + 1 : 1;

        $venta = new Venta();
        $venta->k_venta = $nuevoKVenta;
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

}
