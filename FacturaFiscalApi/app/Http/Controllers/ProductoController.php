<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\Validator;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::orderBy('k_articulo', 'ASC')->limit(10)->get();
        return response()->json([
            'message' => 'Lista de productos',
            'data' => $productos,
            'status' => '200'
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'articulo_nombre' => 'required',
            'articulo_unidad' => 'required',    
            'articulo_precio' => 'required',
            'articulo_poriva' => 'required',
            'articulo_codigo_sat' => 'required',
            'articulo_unidad_sat' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $producto = new Producto();
        $producto->fill($request->all());
        if ($producto->save()) {
            return response()->json([
                'message' => 'Producto creado correctamente',
                'data' => $producto,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Error al crear producto',
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

        $producto = Producto::where('k_articulo', $id)->where('k_empresa', $request->k_empresa)->first();
        if ($producto) {
            return response()->json([
                'message' => 'Producto encontrado',
                'data' => $producto,
                'status' => '200'
            ], 200);
        }
        return response()->json([
            'message' => 'Producto no encontrado',
            'status' => '404'
        ], 404);
    }

    /*
    // Se actualizan todos los productos con el id, da igual la empresa aunque en el where este el k_empresa
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'k_empresa' => 'required',
            'articulo_nombre' => 'required',
            'articulo_unidad' => 'required',    
            'articulo_precio' => 'required',
            'articulo_poriva' => 'required',
            'articulo_codigo_sat' => 'required',
            'articulo_unidad_sat' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error al validar datos',
                'errors' => $validator->errors(),
                'status' => '400'
            ], 400);
        }

        $producto = Producto::where('k_articulo', $id)->where('k_empresa', $request->k_empresa)->first();
        if ($producto) {
            $producto->fill($request->all());
            if ($producto->save()) {
                return response()->json([
                    'message' => 'Producto actualizado correctamente',
                    'data' => $producto,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al actualizar producto',
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Producto no encontrado',
            'status' => '404'
        ], 404);
    }*/

    /*
    // Se eliminan todos los productos con el id, da igual la empresa aunque en el where este el k_empresa
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

        $producto = Producto::where('k_articulo', $id)->where('k_empresa', $request->k_empresa)->first();
        if ($producto) {
            if ($producto->delete()) {
                return response()->json([
                    'message' => 'Producto eliminado correctamente',
                    'data' => $producto,
                    'status' => '200'
                ], 200);
            }
            return response()->json([
                'message' => 'Error al eliminar producto',
                'status' => '400'
            ], 400);
        }
        return response()->json([
            'message' => 'Producto no encontrado',
            'status' => '404'
        ], 404);
    }*/
}
