<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_tipo_predio extends Model
{
    protected $table = 'tb_tipo_predios';

    protected $fillable = ['tipo_predio','estado'];

    public $timestamps = false;
}
