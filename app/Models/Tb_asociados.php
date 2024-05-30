<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_asociados extends Model
{
    protected $table = 'tb_asociados';

    protected $fillable = ['novedad','estado'];

    public $timestamps = false;

    public function Personas()
    {
        return $this->belongsTo(Tb_personas::class);
    }

    public function Fincas()
    {
        return $this->belongsTo(Tb_fincas::class);
    }

    public function Categoria()
    {
        return $this->belongsTo(Tb_categorias::class);
    }
}
