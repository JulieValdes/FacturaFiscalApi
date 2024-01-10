<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = ['k_empresa', 'k_venta', 'k_sujeto', 'venta_fecha', 'venta_subtotal', 'venta_iva', 'venta_ieps', 'venta_retencion', 'venta_total', 'venta_costo', 'venta_orden_compra', 'venta_comentario1', 'venta_comentario2', 'venta_fin', 'venta_factura', 'venta_UUID', 'venta_foliofact', 'venta_formapago', 'venta_condiciones', 'venta_serie', 'venta_folio', 'venta_tipo', 'venta_metodo', 'venta_cadena', 'ventas_cancelada', 'venta_moneda', 'venta_tcambio', 'venta_descuento', 'venta_motivo_desc', 'venta_local', 'venta_local_ret', 'venta_comenta_metodo', 'venta_lugar', 'venta_pagado', 'venta_uso_cfdi', 'tipo_relacion', 'uuid_relacionado' ];
    public $timestamps = false;
}
