<?php

use App\Models\Tb_parentesco;
use Illuminate\Database\Seeder;

class Tb_parentescoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_parentesco.json'));
        foreach ($data as $item){
            Tb_parentesco::create(array(
                'id' => $item->id,
                'parentesco' => $item->parentesco,
                'estado' => $item->estado,
            ));
            }
    }
}
