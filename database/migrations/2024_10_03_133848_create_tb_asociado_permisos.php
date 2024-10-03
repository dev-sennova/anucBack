<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAsociadoPermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_asociado_permisos', function (Blueprint $table) {
            $table->id();
            // Clave foránea para asociados
            $table->unsignedBigInteger('asociado');
            $table->foreign('asociado')->references('id')->on('tb_asociados');

            // Clave interna para visualizacion 1 publico, 2 privada, 3 asociados
            $table->integer('telefono')->default(2);
            $table->integer('correo')->default(2);
            $table->integer('whatsapp')->default(2);
            $table->integer('facebook')->default(2);
            $table->integer('instagram')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_asociado_permisos');
    }
}
