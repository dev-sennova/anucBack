<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_parentesco extends Model
{
    protected $table = 'tb_parentescos';

    protected $fillable = ['parentesco','estado'];

    public $timestamps = false;
}
