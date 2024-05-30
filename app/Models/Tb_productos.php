<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_productos extends Model
{
    protected $table = 'tb_productos';

    protected $fillable = ['estado'];

    public $timestamps = false;

    public function productoCategoria()
    {
        return $this->belongsTo(Tb_producto_categorias::class);
    }
}
