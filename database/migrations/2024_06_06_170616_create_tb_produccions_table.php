<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProduccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_produccion', function (Blueprint $table) {
            $table->id();
            $table->integer('produccion');
            $table->boolean('estado')->default(1);

            // Clave foránea para periodicidad
            $table->unsignedBigInteger('periodicidad');
            $table->foreign('periodicidad')->references('id')->on('tb_periodicidad');

            // Clave foránea para productos
            $table->unsignedBigInteger('producto');
            $table->foreign('producto')->references('id')->on('tb_productos');

            // Clave foránea para medida
            $table->unsignedBigInteger('medida');
            $table->foreign('medida')->references('id')->on('tb_medida_unidades');

            // Clave foránea para producto asociados_finca
            $table->unsignedBigInteger('asociados_finca');
            $table->foreign('asociados_finca')->references('id')->on('tb_asociados_fincas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_produccions');
    }
}
