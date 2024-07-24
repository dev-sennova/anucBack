<?php

use App\Models\Tb_produccion;
use Illuminate\Database\Seeder;

class Tb_produccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_produccion.json'));
        foreach ($data as $item){
            Tb_produccion::create(array(
                'id' => $item->id,
                'produccion' => $item->produccion,
                'estado' => $item->estado,
                'periodicidad' => $item->periodicidad,
                'producto' => $item->producto,
                'medida' => $item->medida,
                'asociados_finca' => $item->asociados_finca
            ));
            }
    }
}
