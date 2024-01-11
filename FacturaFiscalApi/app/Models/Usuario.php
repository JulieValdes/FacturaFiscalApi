<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Usuario extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    protected $table = 'usrs';
    protected $primaryKey = 'k_user';
    protected $fillable = ['k_user','email', 'nombre','pass', 'es_super_admin','puede_agregar_usrs','puede_cambiar_fecha'];
    public $timestamps = false;
}
