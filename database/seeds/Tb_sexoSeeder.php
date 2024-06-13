<?php

use App\Models\Tb_sexo;
use Illuminate\Database\Seeder;

class Tb_sexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_sexo.json'));
        foreach ($data as $item){
            Tb_sexo::create(array(
                'id' => $item->id,
                'sexo' => $item->sexo,
                'estado' => $item->estado,
            ));
            }
    }
}
