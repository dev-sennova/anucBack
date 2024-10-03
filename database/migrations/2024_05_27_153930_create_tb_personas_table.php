<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_personas', function (Blueprint $table) {
            $table->id();
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->boolean('estado')->default(1);

            // Clave foránea para el tipo de documento
            $table->unsignedBigInteger('tipo_documento');
            $table->foreign('tipo_documento')->references('id')->on('tb_tipo_documento');

            // Clave foránea para el sexo
            $table->unsignedBigInteger('sexo');
            $table->foreign('sexo')->references('id')->on('tb_sexo');

            // Clave foránea para el estado civil
            $table->unsignedBigInteger('estado_civil');
            $table->foreign('estado_civil')->references('id')->on('tb_estado_civil');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_personas');
    }
}
