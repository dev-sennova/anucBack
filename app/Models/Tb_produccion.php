<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_produccion extends Model
{
    protected $table = 'tb_produccion';

    protected $fillable = ['produccion','estado'];

    public $timestamps = false;

    public function Asociado()
    {
        return $this->belongsTo(Tb_asociados::class);
    }

    public function Producto()
    {
        return $this->belongsTo(Tb_productos::class);
    }

    public function Medida()
    {
        return $this->belongsTo(Tb_medida_unidades::class);
    }
}
