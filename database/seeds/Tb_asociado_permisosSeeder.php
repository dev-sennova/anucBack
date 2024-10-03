<?php

use App\Models\Tb_asociado_permisos;
use Illuminate\Database\Seeder;

class Tb_asociado_permisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_asociado_permisos.json'));
        foreach ($data as $item){
            Tb_asociado_permisos::create(array(
                'id' => $item->id,
                'asociado' => $item->asociado,
                'correo' => $item->correo,
                'telefono' => $item->telefono,
                'whatsapp' => $item->whatsapp,
                'facebook' => $item->facebook,
                'instagram' => $item->instagram
            ));
            }
    }
}
