<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbHojaDeCostosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_hoja_de_costos', function (Blueprint $table) {
            $table->id();
            $table->string('fechaInicio');
            $table->string('fechaFin');
            $table->string('descripcion');
            $table->string('unidad');
            $table->integer('cantidad');
            $table->integer('esperado');
            $table->boolean('estado')->default(1);
            $table->unsignedBigInteger('idProducto');
            $table->unsignedBigInteger('idAsociado');
            $table->foreign('idProducto')->references('id')->on('tb_productos');
            $table->foreign('idAsociado')->references('id')->on('tb_asociados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_hoja_de_costos');
    }
}
