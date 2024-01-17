<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VentaController extends Controller
{
    public function index(){
        $ventas = Venta::orderBy('k_venta', 'desc')->limit(50)->get();
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
        
        

        $ultimaVenta = Venta::where('k_empresa', $request->k_empresa)->max('k_venta');
        $venta = new Venta();
        if ($ultimaVenta !== null) {
            $venta->k_venta = $ultimaVenta + 1;
        }
        $venta->fill($request->all());
        if ($venta->save()) {
            
            $consulta = DB::table('ventas')
            ->select('k_venta')
            ->where('k_empresa', $request->k_empresa)
            ->where('k_sujeto', $request->k_sujeto)
            ->orderBy('venta_fecha', 'desc')
            ->orderBy('k_venta', 'desc')
            ->limit(1);
    
            $ultimaId = $consulta->value('k_venta');

            return response()->json([
                'message' => 'Venta creada correctamente',
                'data' => $venta,
                'k_venta' => $ultimaId,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear venta',
            'data' => $venta,
            'status' => '400'
        ], 400);

    }

    //problemas con empresas que tiene registros repetidos
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

        
        $result = Venta::where('k_venta', $id)
               ->where('k_empresa', $request->k_empresa)
               ->where('k_sujeto', $request->k_sujeto)
               ->update($request->all());
        
        if($result){
            $venta = Venta::where('k_venta', $id)
            ->where('k_empresa', $request->k_empresa)
            ->where('k_sujeto', $request->k_sujeto)
            ->first();
            return response()->json([
                'message' => 'Venta actualizada correctamente',
                'data' => $venta,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al actualizar venta',
            'status' => '400'
        ], 400);
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

        $result = Venta::where('k_venta', $id)->where('k_empresa', $request->k_empresa)->where('k_sujeto', $request->k_sujeto)->delete();

        if ($result) {
            return response()->json([
                'message' => 'Producto eliminado correctamente',
                'data' => $venta,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Error al eliminar producto',
            'status' => '400'
        ], 400);
    }
}
