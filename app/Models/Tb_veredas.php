<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_veredas extends Model
{
    protected $table = 'tb_veredas';

    protected $fillable = ['vereda','estado'];

    public $timestamps = false;

    public function Ciudad()
    {
        return $this->belongsTo(Tb_ciudades::class);
    }
}
