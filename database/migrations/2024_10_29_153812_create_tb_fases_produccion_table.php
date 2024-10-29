<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFasesProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_fases_produccion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_fase');
            $table->longText('descripcion');
            $table->boolean('estado')->default(1);

            // Clave foránea para producto categoria
            $table->unsignedBigInteger('idGrupo');
            $table->foreign('idGrupo')->references('id')->on('tb_grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_fases_produccion');
    }
}
