<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_productos extends Model
{
    protected $table = 'tb_productos';

    protected $fillable = ['producto','estado'];

    public $timestamps = false;

    public function productoCategoria()
    {
        return $this->belongsTo(Tb_producto_categorias::class,'categoria');
    }

    public function oferta()
    {
    return $this->hasMany(Tb_oferta::class, 'product_id');
    }
}
