<?php

use App\Models\Tb_generalidades_produccion;
use Illuminate\Database\Seeder;

class Tb_generalidades_produccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_generalidades_produccion.json'));
        foreach ($data as $item){
            Tb_generalidades_produccion::create(array(
                'id' => $item->id,
                'pregunta_1' => $item->pregunta_1,
                'pregunta_2' => $item->pregunta_2,
                'pregunta_3' => $item->pregunta_3,
                'pregunta_4' => $item->pregunta_4,
                'pregunta_5' => $item->pregunta_5,
                'pregunta_6' => $item->pregunta_6,
                'idGrupo' => $item->idGrupo,
                'estado' => $item->estado,
            ));
            }
    }
}
