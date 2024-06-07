<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAsociadosFincasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_asociados_fincas', function (Blueprint $table) {
            $table->id();
            $table->boolean('estado')->default(1);

            // Clave foránea para producto finca
            $table->unsignedBigInteger('finca');
            $table->foreign('finca')->references('id')->on('tb_fincas');

            // Clave foránea para producto asociado
            $table->unsignedBigInteger('asociado');
            $table->foreign('asociado')->references('id')->on('tb_asociados');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_asociados_fincas');
    }
}
