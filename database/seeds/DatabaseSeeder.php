<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'users'
        ]);

        //funcion principal que llama cada seeder
        $this->call(UsersSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_empresa_globales'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_empresa_globalesSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_periodicidad'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_periodicidadSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_ciudades'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_ciudadSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_estado_civil'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_estado_civilSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_medida_unidades'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_medida_unidadesSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_parentescos'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_parentescoSeeder::class);
//-------------------------------------------------------------------////-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_producto_categorias'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_producto_categoriasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_productos'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_productosSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_sexo'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_sexoSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_tipo_documento'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_tipo_documentoSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_tipo_predios'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_tipo_predioSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_veredas'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_veredasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_personas'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_personasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_fincas'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_fincasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_categorias'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_categoriasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_asociados'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_asociadosSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_asociados_fincas'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_asociados_fincasSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_produccion'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_produccionSeeder::class);
//-------------------------------------------------------------------//
//-------------------------------------------------------------------//
        //primero vacia la tabla y luego la llena ojo
        $this->truncateTables([
            'tb_familiares'
        ]);

        //funcion principal que llama cada seeder
        $this->call(Tb_familiaresSeeder::class);
//-------------------------------------------------------------------//

//-------------------------------------------------------------------//
//-------------------------------------------------------------------//

//--Tener cuidado con este cierre--//
    }
//--Tener cuidado con este cierre--//

    //funcion que deshabilita revision de claves foraneas para borrar tablas y luego la habilita nuevamente
    protected function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
