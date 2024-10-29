<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbGeneralidadesProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_generalidades_produccion', function (Blueprint $table) {
            $table->id();
            $table->string('pregunta_1');
            $table->string('pregunta_2');
            $table->string('pregunta_3');
            $table->string('pregunta_4');
            $table->string('pregunta_5');
            $table->string('pregunta_6');
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
        Schema::dropIfExists('tb_generalidades_produccion');
    }
}
