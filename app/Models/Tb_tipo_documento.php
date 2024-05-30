<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_tipo_documento extends Model
{
    protected $table = 'tb_tipo_documento';

    protected $fillable = ['tipo_documento','estado'];

    public $timestamps = false;
}
