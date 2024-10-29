<?php

use App\Models\Tb_fases_produccion;
use Illuminate\Database\Seeder;

class Tb_fases_produccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_fases_produccion.json'));
        foreach ($data as $item){
            Tb_fases_produccion::create(array(
                'id' => $item->id,
                'nombre_fase' => $item->nombre_fase,
                'descripcion' => $item->descripcion,
                'idGrupo' => $item->idGrupo,
                'estado' => $item->estado,
            ));
            }
    }
}
