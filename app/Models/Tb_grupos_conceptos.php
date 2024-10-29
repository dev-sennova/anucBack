<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_grupos_conceptos extends Model
{
    protected $table = 'tb_grupos_conceptos';

    protected $fillable = ['grupo','estado'];

    public $timestamps = false;
}
