<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_familiares extends Model
{
    protected $table = 'tb_familiares';

    protected $fillable = ['parentesco','estado'];

    public $timestamps = false;

    public function Asociado()
    {
        return $this->belongsTo(Tb_asociados::class);
    }

    public function Persona()
    {
        return $this->belongsTo(Tb_personas::class);
    }
}
