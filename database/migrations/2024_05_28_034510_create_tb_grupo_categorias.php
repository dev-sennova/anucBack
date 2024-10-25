<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbGrupoCategorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_grupo_categorias', function (Blueprint $table) {
            $table->id();
            // Clave foránea para producto categoria
            $table->unsignedBigInteger('idGrupo');
            $table->foreign('idGrupo')->references('id')->on('tb_grupos');
            $table->unsignedBigInteger('idProducto');
            $table->foreign('idProducto')->references('id')->on('tb_productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_grupo_categorias');
    }
}
