<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'mis_datos';
    
    protected $fillable = ['k_empresa','mis_datos_nombre', 'mis_datos_razon-social', 'mis_datos_rfc', 'mis_datos_calle', 'mis_datos_no_ext','mis_datos_num_int', 'mis_datos_colonia','mis_datos_localidad', 'mis_datos_municipio','mis_datos_estado', 'mis_datos_pais', 'mis_datos_cp', 'mis_datos_archivo_key','mis_datos_archivo_cert', 'mis_datos_fecha_inicio','mis_datos_fecha_fin', 'mis_datos_no_cert', 'mis_datos_regimen', 'mis_datos_logo_pagina', 'mis_datos_logo_factura', 'mis_datos_email', 'mis_datos_renglones', 'mis_datos_formapago', 'mis_datos_condicionespago', 'mis_datos_metodopago','mis_datos_pwd_key','mis_datos_credito','mis_datos_retenciones' ,'mis_datos_impuestos','mis_datos_linea1' ,'mis_datos_linea2','mis_datos_linea3','mis_datos_mostrar_claveext', 'mis_datos_mostrar_codigo' , 'mis_datos_cxc' , 'mis_datos_pos_logo' , 'mis_datos_tam_logo', 'mis_datos_margen_i','mis_datos_margen_d' , 'mis_datos_margen_ar' , 'mis_datos_margen_ab' , 'mis_datos_iva0' , 'mis_datos_por_descuento' , 'mis_datos_descuento', 'mis_datos_metodo_abierto' , 'mis_datos_mostrar_alias_listado' , 'mis_datos_mostrar_rfc_listado' , 'mis_datos_lugar' , 'alta_por' , 'fecha_alta', 'mis_datos_cadena', 'mis_datos_decimales' , 'mis_datos_version' , 'mis_datos_mostrar_regimen' ,'mis_datos_mostrar_moneda' , 'mis_datos_mostrar_tipo' , 'mis_datos_mostrar_tipo_cfdi', 'mis_datos_formato' ,  'mis_datos_forma_abierto' , 'mis_datos_formato_pago' ,'bloqueado' , 'datos_adicionales','donativo' , 'mis_datos_descarga_sat'];


}
