<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_asociado_permisos extends Model
{
    protected $table = 'tb_asociado_permisos';

    protected $fillable = ['asociado','telefono','correo','whatsapp','facebook','instagram'];

    public $timestamps = false;

    public function asociados()
    {
        return $this->belongsTo(Tb_asociados::class,'asociado','id');
    }
}
