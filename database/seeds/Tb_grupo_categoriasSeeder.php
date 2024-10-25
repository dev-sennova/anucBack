<?php

use App\Models\Tb_grupo_categorias;
use Illuminate\Database\Seeder;

class Tb_grupo_categoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_grupo_categorias.json'));
        foreach ($data as $item){
            Tb_grupo_categorias::create(array(
                'id' => $item->id,
                'idGrupo' => $item->idGrupo,
                'idProducto' => $item->idProducto
            ));
            }
    }
}
