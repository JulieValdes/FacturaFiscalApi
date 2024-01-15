<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    protected $primaryKey = 'k_articulo';
    protected $fillable = ['k_articulo', 'k_empresa', 'articulo_clave', 'articulo_nombre', 'articulo_codigo', 'articulo_unidad', 'articulo_almacenable', 'articulo_precio', 'articulo_costo', 'articulo_poriva', 'articulo_retiva', 'articulo_retisr', 'borrado', 'articulo_codigo_sat', 'articulo_unidad_sat'];
    public $timestamps = false;
}
