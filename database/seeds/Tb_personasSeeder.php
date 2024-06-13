<?php

use App\Models\Tb_personas;
use Illuminate\Database\Seeder;

class Tb_personasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_personas.json'));
        foreach ($data as $item){
            Tb_personas::create(array(
                'id' => $item->id,
                'nombres' => $item->nombres,
                'apellidos' => $item->apellidos,
                'telefono' => $item->telefono,
                'fecha_nacimiento' => $item->fecha_nacimiento,
                'tipo_documento' => $item->tipo_documento,
                'identificacion' => $item->identificacion,
                'sexo' => $item->sexo,
                'estado_civil' => $item->estado_civil,
                'estado' => $item->estado,
            ));
            }
    }
}
