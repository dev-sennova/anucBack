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

            // Clave foránea para producto categoria
            $table->unsignedBigInteger('idConcepto');
            $table->foreign('idConcepto')->references('id')->on('tb_conceptos');

            // Clave foránea para producto categoria
            $table->unsignedBigInteger('idHojaCostos');
            $table->foreign('idHojaCostos')->references('id')->on('tb_hoja_de_costos');
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
