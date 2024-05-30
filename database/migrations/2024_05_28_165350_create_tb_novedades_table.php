<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNovedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_novedades', function (Blueprint $table) {
            $table->id();
            $table->string('novedad');
            $table->boolean('estado')->default(1);

            // Clave foránea para asociados
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
        Schema::dropIfExists('tb_novedades');
    }
}
