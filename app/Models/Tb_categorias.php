<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_categorias extends Model
{
    protected $table = 'tb_categorias';

    protected $fillable = ['categoria','estado'];

    public $timestamps = false;
}
