<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_grupos extends Model
{
    protected $table = 'tb_grupos';

    protected $fillable = ['grupo','descripcion','estado'];

    public $timestamps = false;
}
