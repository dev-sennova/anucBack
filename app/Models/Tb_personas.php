<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_personas extends Model
{
    protected $table = 'tb_personas';

    protected $fillable = ['identificacion','nombres','apellidos','telefono','fecha_nacimiento','estado'];

    public $timestamps = false;

    public function tipoDocumento()
    {
        return $this->belongsTo(Tb_tipo_documento::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Tb_sexo::class);
    }

    public function estadoCivil()
    {
        return $this->belongsTo(Tb_estado_civil::class);
    }
}
