<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VentaProducto;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class VentaProductoController extends Controller
{
    public function index()
    {
        $ventasProductos = VentaProducto::orderBy('k_ventas_productos', 'DESC')->limit(10)->get();

        return response()->json([
            'message' => 'Lista de ventas de productos',
            'data' => $ventasProductos,
            'status' => '200'
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'k_venta' => 'required',
            'k_articulo' => 'required',
            'ventas_productos_cantidad' => 'required',
            'ventas_productos_precio' => 'required',
            'ventas_productos_subtotal' => 'required',
            'ventas_productos_IVA' => 'required',
            'ventas_productos_total' => 'required',
            'ventas_productos_comentario' => 'required',
            'ventas_productos_unidad' => 'required',
            'ventas_productos_descuento' => 'required',
            'ventas_productos_usar_coment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $ultimaVentaProducto = VentaProducto::where('k_empresa', $request->k_empresa)->max('k_ventas_productos');
        $ultimaVentaProducto = $ultimaVentaProducto + 1;
        $ventaProducto = new VentaProducto();
        $ventaProducto->k_ventas_productos = $ultimaVentaProducto;
        $ventaProducto->fill($request->all());

        if ($ventaProducto->save()) {

            $consulta = DB::table('ventas_productos')
                ->where('k_empresa', $request->k_empresa)
                ->where('k_venta', $request->k_venta)
                ->where('k_articulo', $request->k_articulo)
                ->orderByRaw('CAST(k_ventas_productos AS UNSIGNED) DESC')
                ->limit(1)
                ->first();

            return response()->json([
                'message' => 'Venta de producto creada correctamente',
                'data' => $consulta,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Error al crear venta de producto',
            'status' => '400'
        ], 400);
    }

    public function show($id, Request $request)
    {
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

        $ventaProducto = VentaProducto::where('k_empresa', $request->k_empresa)
            ->where('k_ventas_productos', $id)
            ->first();

        if ($ventaProducto) {
            return response()->json([
                'message' => 'Venta de producto encontrada',
                'data' => $ventaProducto,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Venta de producto no encontrada',
            'status' => '404'
        ], 404);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'k_venta' => 'required',
            'k_articulo' => 'required',
            'ventas_productos_cantidad' => 'required',
            'ventas_productos_precio' => 'required',
            'ventas_productos_porIVA' => 'required',
            'ventas_productos_subtotal' => 'required',
            'ventas_productos_IVA' => 'required',
            'ventas_productos_total' => 'required',
            'ventas_productos_comentario' => 'required',
            'ventas_productos_unidad' => 'required',
            'ventas_productos_descuento' => 'required',
            'ventas_productos_cuenta_predial' => 'required',
            'ventas_productos_usar_coment' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $result = VentaProducto::where('k_ventas_productos', $id)
            ->where('k_empresa', $request->k_empresa)
            ->update($request->all());

        if ($result) {
            $ventaProducto = VentaProducto::where('k_ventas_productos', $id)
                ->where('k_empresa', $request->k_empresa)
                ->first();

            return response()->json([
                'message' => 'Venta de producto actualizada correctamente',
                'data' => $ventaProducto,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Error al actualizar venta de producto',
            'status' => '400'
        ], 400);
    }

    public function delete($id, Request $request)
    {
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

        $ventaProducto = VentaProducto::where('k_ventas_productos', $id)
            ->where('k_empresa', $request->k_empresa)
            ->first();

        $result = VentaProducto::where('k_ventas_productos', $id)
            ->where('k_empresa', $request->k_empresa)
            ->delete();

        if ($result) {
            return response()->json([
                'message' => 'Venta de producto eliminada correctamente',
                'data' => $ventaProducto,
                'status' => '200'
            ], 200);
        }

        return response()->json([
            'message' => 'Error al eliminar venta de producto',
            'status' => '400'
        ], 400);
    }
}
