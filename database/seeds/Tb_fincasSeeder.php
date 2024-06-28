<?php

use App\Models\Tb_fincas;
use Illuminate\Database\Seeder;

class Tb_fincasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_fincas.json'));
        foreach ($data as $item){
            Tb_fincas::create(array(
                'id' => $item->id,
                'nombre' => $item->nombre,
                'extension' => $item->extension,
                'latitud' => $item->latitud,
                'longitud' => $item->longitud,
                'vereda' => $item->vereda,
                'estado' => $item->estado,
            ));
            }
    }
}
