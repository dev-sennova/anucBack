<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_asociados extends Model
{
    protected $table = 'tb_asociados';

    protected $fillable = ['estado'];

    public $timestamps = false;

    public function personas()
    {
        return $this->belongsTo(Tb_personas::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Tb_categorias::class);
    }
}
