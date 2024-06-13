<?php

use App\Models\Tb_estado_civil;
use Illuminate\Database\Seeder;

class Tb_estado_civilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_estado_civil.json'));
        foreach ($data as $item){
            Tb_estado_civil::create(array(
                'id' => $item->id,
                'estado_civil' => $item->estado_civil,
                'estado' => $item->estado,
            ));
            }
    }
}
