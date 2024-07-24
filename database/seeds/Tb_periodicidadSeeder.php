<?php

use App\Models\Tb_periodicidad;
use Illuminate\Database\Seeder;

class Tb_periodicidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_periodicidad.json'));
        foreach ($data as $item){
            Tb_periodicidad::create(array(
                'id' => $item->id,
                'periodicidad' => $item->periodicidad,
                'estado' => $item->estado,
            ));
            }
    }
}
