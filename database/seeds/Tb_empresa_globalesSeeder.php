<?php

use App\Models\Tb_empresa_globales;
use Illuminate\Database\Seeder;

class Tb_empresa_globalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_empresa_globales.json'));
        foreach ($data as $item){
            Tb_empresa_globales::create(array(
                'id' => $item->id,
                'nombre' => $item->nombre,
                'nit' => $item->nit,
                'horarios' => $item->horarios,
                'horariosCargue' => $item->horariosCargue,
                'telefono' => $item->telefono,
                'correo' => $item->correo,
                'whatsapp' => $item->whatsapp,
                'facebook' => $item->facebook,
                'instagram' => $item->instagram,
                'mision' => $item->mision,
                'vision' => $item->vision,
                'direccion' => $item->direccion,
                'estatutos' => $item->estatutos,
                'estado' => $item->estado
            ));
            }
    }
}
