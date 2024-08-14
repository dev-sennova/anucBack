<?php

use App\Models\Tb_veredas;
use Illuminate\Database\Seeder;

class Tb_veredasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_veredas.json'));
        foreach ($data as $item){
            Tb_veredas::create(array(
                'id' => $item->id,
                'vereda' => $item->vereda,
                'latitud' => $item->latitud,
                'longitud' => $item->longitud,
                'ciudad' => $item->ciudad,
                'estado' => $item->estado,
            ));
            }
    }
}
