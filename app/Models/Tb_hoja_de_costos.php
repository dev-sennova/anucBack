<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_hoja_de_costos extends Model
{
    protected $table = 'tb_hoja_de_costos';

    protected $fillable = ['idProducto','idAsociado','fechaInicio','fechaFin','descripcion','cantidad','esperado','estado'];

    public $timestamps = false;
}
