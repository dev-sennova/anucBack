<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_novedades extends Model
{
    protected $table = 'tb_novedades';

    protected $fillable = ['novedad','estado'];

    public $timestamps = false;

    public function asociado()
    {
        return $this->belongsTo(Tb_asociados::class);
    }
}
