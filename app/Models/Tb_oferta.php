<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Tb_oferta extends Model
{
    protected $table = 'tb_ofertas';

    protected $fillable = ['product_id','asociados_finca_id','start_date','end_date','imagenProducto','telefono_visible','telefono',
    'whatsapp_visible','whatsapp','correo_visible','correo','facebook_visible','facebook','instagram_visible','instagram',
    'cantidad','precio','descripcion','estado'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Tb_productos::class, 'product_id');
    }
    public function asociadosFinca()
    {
        return $this->belongsTo(Tb_asociados_fincas::class, 'asociados_finca_id');
    }
    public function medidaUnides()
    {
        return $this->belongsTo(Tb_medida_unidades::class, 'medida_unidades_id');
    }

}
