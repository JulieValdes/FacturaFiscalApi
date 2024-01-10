<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'articulos';

    protected $fillable = ['k_articulo', 'k_empresa', 'articulo_clave', 'articulo_nombre', 'articulo_codigo', 'articulo_unidad', 'articulo_almacenable', 'articulo_precio', 'articulo_costo', 'articulo_poriva', 'articulo_retiva', 'articulo_retisr', 'borrado', 'articulo_codigo_sat', 'articulo_unidad_sat'];

    public $timestamps = false;

        /* k_empresa int 
    k_articulo varchar(10) 
    articulo_clave varchar(45) 
    articulo_nombre varchar(1000) 
    articulo_codigo varchar(45) 
    articulo_unidad varchar(45) 
    articulo_almacenable tinyint 
    articulo_precio decimal(15,2) 
    articulo_costo decimal(15,2) 
    articulo_poriva decimal(10,2) 
    articulo_retiva decimal(10,4) 
    articulo_retisr decimal(10,4) 
    borrado smallint 
    articulo_codigo_sat varchar(250) 
    articulo_unidad_sat varchar(250)*/
}
