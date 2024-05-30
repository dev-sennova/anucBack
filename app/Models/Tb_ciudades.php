<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_ciudades extends Model
{
    protected $table = 'tb_ciudades';

    protected $fillable = ['ciudad','estado'];

    public $timestamps = false;
}
