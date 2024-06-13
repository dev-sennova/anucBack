<?php

use App\Models\Tb_medida_unidades;
use Illuminate\Database\Seeder;

class Tb_medida_unidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_medida_unidades.json'));
        foreach ($data as $item){
            Tb_medida_unidades::create(array(
                'id' => $item->id,
                'unidad' => $item->unidad,
                'estado' => $item->estado,
            ));
            }
    }
}
