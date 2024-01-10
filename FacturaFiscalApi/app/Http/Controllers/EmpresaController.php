<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('mis_datos_nombre', 'DESC')->limit(50)->get();

        return response()->json([
            'message' => 'Lista de empresas',
            'data' => $empresas,
            'status' => '200'
        ], 200);
    }
}
