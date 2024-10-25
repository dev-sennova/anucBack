<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_grupo_categorias extends Model
{
    protected $table = 'tb_grupo_categorias';

    protected $fillable = ['idGrupo','idProducto'];

    public $timestamps = false;

    public function grupo()
    {
        return $this->belongsTo(Tb_grupos::class,'idGrupo','id');
    }

    public function producto()
    {
        return $this->belongsTo(Tb_productos::class,'idProducto','id');
    }
}
