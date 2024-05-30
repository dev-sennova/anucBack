<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_sexo extends Model
{
    protected $table = 'tb_sexo';

    protected $fillable = ['sexo','estado'];

    public $timestamps = false;
}
