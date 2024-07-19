<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Tb_oferta extends Model
{
    protected $table = 'tb_ofertas';

    protected $fillable = ['product_id','asociados_finca_id','start_date','end_date','estado'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Tb_productos::class, 'product_id');
    }
    public function asociadosFinca()
    {
        return $this->belongsTo(Tb_asociados_fincas::class, 'asociados_finca_id');
    }
}
