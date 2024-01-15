<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
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

    //YA AUMENTA, SÓLO QUE EN LA EMPRESA 1 POR ALGUNA RAZÓN NO ESTÁ AUMENTANDO K_VENTA
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

        $ultimaVenta = Venta::where('k_empresa', $request->k_empresa)->orderBy('k_venta', 'DESC')->first();
        $venta = new Venta();
        if ($ultimaVenta) {
            $venta->k_venta = $ultimaVenta->k_venta + 1;
        } else {
            $venta->k_venta = 1;
        }
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

    //problemas con empresas  que tiene registros repetidos
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


    //No encuentra la venta aunque se especifiquen los datos
    // En workbench está indicando que no se encuentra un procedure llamado SET_NC y por eso no se puede hacer la actualización
    //De igual manera hay un problema ya que al parecer se implementó un modo seguro de actualización y eso también esta impidiendo que se actualice de manera normal
    public function update(int $id, Request $request)
    {
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

        try {
            DB::beginTransaction();

            // Mover el inicio de la transacción al inicio de la función
            $venta = Venta::where('k_venta', $id)
                ->where('k_empresa', $request->k_empresa)
                ->where('k_sujeto', $request->k_sujeto)
                ->first();

            if ($venta) {
                $venta->fill($request->all());

                if ($venta->save()) {
                    // Hacer el commit después de la operación de actualización
                    DB::commit();

                    return response()->json([
                        'message' => 'Venta actualizada correctamente',
                        'data' => $venta,
                        'status' => '200'
                    ], 200);
                }
            }

            // Hacer el rollback si la venta no existe o no se actualiza correctamente
            DB::rollback();

            return response()->json([
                'message' => 'Venta no encontrada o error al actualizar',
                'status' => '404'
            ], 404);
        } catch (\Exception $e) {
            // Manejar errores inesperados y hacer el rollback
            DB::rollback();

            return response()->json([
                'message' => 'Error inesperado al actualizar venta',
                'status' => '500'
            ], 500);
        }
    }

    //se estan borrando todos los registros con el mismo k_venta
    /*public function delete($id, Request $request){

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
    }*/
}
