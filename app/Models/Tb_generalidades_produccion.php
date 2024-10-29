<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_generalidades_produccion extends Model
{
    protected $table = 'tb_generalidades_produccion';

    protected $fillable = ['pregunta_1','pregunta_2','pregunta_3','pregunta_4','pregunta_5','pregunta_6','idGrupo','estado'];

    public $timestamps = false;
}
