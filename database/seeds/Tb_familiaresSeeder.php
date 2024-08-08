<?php

use App\Models\Tb_familiares;
use Illuminate\Database\Seeder;

class Tb_familiaresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_familiares.json'));
        foreach ($data as $item){
            Tb_familiares::create(array(
                'id' => $item->id,
                'asociado' => $item->asociado,
                'persona' => $item->persona,
                'parentesco' => $item->parentesco,
                'estado' => $item->estado,
            ));
            }
    }
}
