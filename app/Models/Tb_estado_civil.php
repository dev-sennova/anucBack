<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_estado_civil extends Model
{
    protected $table = 'tb_estado_civil';

    protected $fillable = ['estado_civil','estado'];

    public $timestamps = false;
}
