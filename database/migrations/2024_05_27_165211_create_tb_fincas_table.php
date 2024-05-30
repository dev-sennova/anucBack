<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFincasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_fincas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->float('extension');
            $table->string('latitud');
            $table->string('longitud');
            $table->boolean('estado')->default(1);

            // Clave foránea para la vereda
            $table->unsignedBigInteger('vereda');
            $table->foreign('vereda')->references('id')->on('tb_veredas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_fincas');
    }
}
