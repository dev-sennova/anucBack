<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_empresa_globales extends Model
{
    protected $table = 'tb_empresa_globales';

    protected $fillable = ['nombre','direccion','mision','vision','estado'];

    public $timestamps = false;
}
