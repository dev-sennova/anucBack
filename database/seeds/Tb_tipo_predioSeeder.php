<?php

use App\Models\Tb_tipo_predio;
use Illuminate\Database\Seeder;

class Tb_tipo_predioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_tipo_predio.json'));
        foreach ($data as $item){
            Tb_tipo_predio::create(array(
                'id' => $item->id,
                'tipo_predio' => $item->tipo_predio,
                'estado' => $item->estado,
            ));
            }
    }
}
