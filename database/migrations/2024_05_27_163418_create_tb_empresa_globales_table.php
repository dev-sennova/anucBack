<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbEmpresaGlobalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_empresa_globales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('direccion');
            $table->string('nit');
            $table->string('horarios');
            $table->string('horariosCargue');
            $table->string('telefono');
            $table->string('correo');
            $table->string('whatsapp');
            $table->string('facebook');
            $table->string('instagram');
            $table->text('mision');
            $table->text('vision');
            $table->string('vencimiento');
            $table->string('presidente');
            $table->string('secretario');
            $table->longText('estatutos');
            $table->boolean('estado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_empresa_globales');
    }
}
