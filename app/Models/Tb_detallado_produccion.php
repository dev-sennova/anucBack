<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_detallado_produccion extends Model
{
    protected $table = 'tb_detallado_produccion';

    protected $fillable = ['cantidad','valorUnitario','idConcepto','idFase','idHojaCostos','estado'];

    public $timestamps = false;
}
