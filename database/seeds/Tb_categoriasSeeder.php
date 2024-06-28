<?php

use App\Models\Tb_categorias;
use Illuminate\Database\Seeder;

class Tb_categoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_categorias.json'));
        foreach ($data as $item){
            Tb_categorias::create(array(
                'id' => $item->id,
                'categoria' => $item->categoria,
                'estado' => $item->estado,
            ));
            }
    }
}
