<?php

use App\Models\Tb_conceptos;
use Illuminate\Database\Seeder;

class Tb_conceptosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_conceptos.json'));
        foreach ($data as $item){
            Tb_conceptos::create(array(
                'id' => $item->id,
                'concepto' => $item->concepto,
                'idGrupo' => $item->idGrupo,
                'estado' => $item->estado,
            ));
            }
    }
}
