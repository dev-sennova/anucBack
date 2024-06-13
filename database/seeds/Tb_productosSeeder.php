<?php

use App\Models\Tb_productos;
use Illuminate\Database\Seeder;

class Tb_productosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_productos.json'));
        foreach ($data as $item){
            Tb_productos::create(array(
                'id' => $item->id,
                'producto' => $item->producto,
                'categoria' => $item->categoria,
                'estado' => $item->estado,
            ));
            }
    }
}
