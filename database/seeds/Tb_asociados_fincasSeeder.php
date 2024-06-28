<?php

use App\Models\Tb_asociados_fincas;
use Illuminate\Database\Seeder;

class Tb_asociados_fincasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_asociados_fincas.json'));
        foreach ($data as $item){
            Tb_asociados_fincas::create(array(
                'id' => $item->id,
                'finca' => $item->finca,
                'asociado' => $item->asociado,
                'tipo_predio' => $item->tipo_predio,
                'estado' => $item->estado,
            ));
            }
    }
}
