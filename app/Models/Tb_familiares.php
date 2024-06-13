<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_familiares extends Model
{
    protected $table = 'tb_familiares';

    protected $fillable = ['estado'];

    public $timestamps = false;

    public function asociado()
    {
        return $this->belongsTo(Tb_asociados::class);
    }

    public function persona()
    {
        return $this->belongsTo(Tb_personas::class);
    }

    public function parentesco()
    {
        return $this->belongsTo(Tb_parentesco::class);
    }
}
