<?php

use App\Models\Tb_grupos_conceptos;
use Illuminate\Database\Seeder;

class Tb_grupos_conceptosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_grupos_conceptos.json'));
        foreach ($data as $item){
            Tb_grupos_conceptos::create(array(
                'id' => $item->id,
                'grupo' => $item->grupo,
                'estado' => $item->estado,
            ));
            }
    }
}
