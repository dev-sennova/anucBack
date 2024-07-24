<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_produccion extends Model
{
    protected $table = 'tb_produccion';

    protected $fillable = ['produccion','estado'];

    public $timestamps = false;

    public function periodicidad()
    {
        return $this->belongsTo(Tb_periodicidad::class);
    }

    public function producto()
    {
        return $this->belongsTo(Tb_productos::class);
    }

    public function medida()
    {
        return $this->belongsTo(Tb_medida_unidades::class);
    }


    public function asociadosFincas()
    {
        return $this->belongsTo(Tb_asociados_fincas::class);
    }
}
