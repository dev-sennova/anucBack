<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_conceptos extends Model
{
    protected $table = 'tb_conceptos';

    protected $fillable = ['concepto','idGrupo','estado'];

    public $timestamps = false;
}
