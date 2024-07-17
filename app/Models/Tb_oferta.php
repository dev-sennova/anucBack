<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Tb_oferta extends Model
{
     protected $table = 'tb_oferta';

     protected $fillable = ['product_id','asociados_finca_id','start_date','end_date'];

    public $timestamps = false;

    public function productos()
    {
        return $this->belongsTo(Tb_productos::class);
    }
    public function asociados_fincas()
    {
        return $this->belongsTo(Tb_asociados_fincas::class);
    }
}
