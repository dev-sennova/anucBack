<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDetalladoProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_detallado_produccion', function (Blueprint $table) {
            $table->id();
            $table->string('cantidad');
            $table->string('valorUnitario');
            $table->boolean('estado')->default(1);
            $table->unsignedBigInteger('idConcepto');
            $table->unsignedBigInteger('idHojaCostos');
            $table->unsignedBigInteger('idFase');
            $table->foreign('idConcepto')->references('id')->on('tb_conceptos');
            $table->foreign('idHojaCostos')->references('id')->on('tb_hoja_de_costos');
            $table->foreign('idFase')->references('id')->on('tb_fases_produccion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_detallado_produccion');
    }
}
