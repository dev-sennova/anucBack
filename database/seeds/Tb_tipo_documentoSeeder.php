<?php

use App\Models\Tb_tipo_documento;
use Illuminate\Database\Seeder;

class Tb_tipo_documentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_tipo_documento.json'));
        foreach ($data as $item){
            Tb_tipo_documento::create(array(
                'id' => $item->id,
                'tipo_documento' => $item->tipo_documento,
                'estado' => $item->estado,
            ));
            }
    }
}
