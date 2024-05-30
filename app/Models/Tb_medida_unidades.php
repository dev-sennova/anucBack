<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_medida_unidades extends Model
{
    protected $table = 'tb_medida_unidades';

    protected $fillable = ['unidad','estado'];

    public $timestamps = false;
}
