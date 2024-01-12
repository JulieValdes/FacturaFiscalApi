<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEmpresa extends Model
{
    use HasFactory;

    protected $table = 'usrs_empresas';

    //TEMPORALMENTE SE DEFINIRÁ UNA COLUMNA COMO LLAVE PRIMARIA,YA QUE LARAVEL NO PUEDE HACER DELETE SIN UNA LLAVE PRIMARIA
    //Causa muchos problemas que la tabla relación no tenga su id propio :(
    protected $primaryKey = 'k_empresa';

    protected $fillable = ['k_user', 'k_empresa'];
    
    public $timestamps = false;
}
