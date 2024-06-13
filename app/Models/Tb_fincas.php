<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_fincas extends Model
{
    protected $table = 'tb_fincas';

    protected $fillable = ['nombre','extension','latitud','longitud','estado'];

    public $timestamps = false;


    public function vereda()
    {
        return $this->belongsTo(Tb_veredas::class);
    }
}
