<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_periodicidad extends Model
{
    //
    protected $table = 'tb_periodicidad';

    protected $fillable = ['periodicidad','estado'];

    public $timestamps = false;
}
