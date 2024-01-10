<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sujeto extends Model
{
    use HasFactory;

    protected $table = 'sujetos';

    protected $fillable = ['k_empresa', 'k_sujetos', 'sujetos_nombre', 'sujetos_calle', 'sujetos_numero_ext', 'sujetos_numero_int', 'sujetos_colonia', 'sujetos_ciudad', 'sujetos_estado', 'sujetos_cp', 'sujetos_pais', 'sujetos_email', 'sujetos_rfc', 'sujetos_referencia', 'sujetos_alias', 'sujetos_cliente', 'sujetos_proveedor', 'sujetos_telefono', 'borrado', 'sujetos_regimen']; 
}
