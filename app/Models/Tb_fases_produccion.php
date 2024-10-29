<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_fases_produccion extends Model
{
    protected $table = 'tb_fases_produccion';

    protected $fillable = ['nombre_fase','descripcion','idGrupo','estado'];

    public $timestamps = false;
}
