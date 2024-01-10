<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usrs';

    protected $fillable = ['k_user int','email', 'nombre','pass', 'es_super_admin','puede_agregar_usrs','puede_cambiar_fecha'];
    public $timestamps = false;
}
