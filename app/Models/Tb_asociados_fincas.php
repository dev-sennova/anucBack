<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_asociados_fincas extends Model
{
    protected $table = 'tb_asociados_fincas';

    protected $fillable = ['estado'];

    public $timestamps = false;

    public function fincas()
    {
        return $this->belongsTo(Tb_fincas::class);
    }

    public function asociados()
    {
        return $this->belongsTo(Tb_asociados::class);
    }

    public function tipoPredio()
    {
        return $this->belongsTo(Tb_tipo_predio::class);
    }
}
