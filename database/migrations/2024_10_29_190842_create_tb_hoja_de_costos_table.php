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
            $table->string('fecha');
            $table->boolean('estado')->default(1);

            // Clave foránea para producto categoria
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
        Schema::dropIfExists('tb_hoja_de_costos');
    }
}
