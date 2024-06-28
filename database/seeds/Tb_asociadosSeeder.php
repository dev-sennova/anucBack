<?php

use App\Models\Tb_asociados;
use Illuminate\Database\Seeder;

class Tb_asociadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_asociados.json'));
        foreach ($data as $item){
            Tb_asociados::create(array(
                'id' => $item->id,
                'persona' => $item->persona,
                'categoria' => $item->categoria,
                'estado' => $item->estado,
            ));
            }
    }
}
