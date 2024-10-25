<?php

use App\Models\Tb_grupos;
use Illuminate\Database\Seeder;

class Tb_gruposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_grupos.json'));
        foreach ($data as $item){
            Tb_grupos::create(array(
                'id' => $item->id,
                'grupo' => $item->grupo,
                'descripcion' => $item->descripcion,
                'estado' => $item->estado,
            ));
            }
    }
}
