<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaProducto extends Model
{
    use HasFactory;

    protected $table = 'ventas_productos';

    protected $fillable = ['k_ventas_productos', 'k_empresa', 'k_venta', 'k_articulo', 'ventas_productos_cantidad', 'ventas_productos_precio', 'ventas_productos_porIVA', 'ventas_productos_subtotal', 'ventas_productos_IVA', 'ventas_productos_total', 'ventas_productos_comentario', 'ventas_productos_unidad', 'ventas_productos_descuento', 'ventas_productos_cuenta_predial', 'ventas_productos_usar_coment'];

    /*k_ventas_productos bigint 
    k_empresa int 
    k_venta varchar(10) 
    k_articulo varchar(10) 
    ventas_productos_cantidad decimal(15,4) 
    ventas_productos_precio decimal(15,4) 
    ventas_productos_porIVA int 
    ventas_productos_subtotal decimal(15,4) 
    ventas_productos_IVA decimal(15,4) 
    ventas_productos_total decimal(15,4) 
    ventas_productos_comentario varchar(2000) 
    ventas_productos_unidad varchar(100) 
    ventas_productos_descuento decimal(15,4) 
    ventas_productos_cuenta_predial varchar(50) 
    ventas_productos_usar_coment tinyint */
}
