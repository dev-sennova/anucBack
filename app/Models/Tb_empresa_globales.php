<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_empresa_globales extends Model
{
    protected $table = 'tb_empresa_globales';

    protected $fillable = ['nombre','direccion','nit','horarios','horariosCargue','telefono','correo','whatsapp','facebook','instagram',
    'mision','vision','estatutos','estado'];

    public $timestamps = false;
}
