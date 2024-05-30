<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_producto_categorias extends Model
{
    protected $table = 'tb_producto_categorias';

    protected $fillable = ['categoria','estado'];

    public $timestamps = false;
}
