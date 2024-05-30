<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbVeredasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_veredas', function (Blueprint $table) {
            $table->id();
            $table->string('vereda');
            $table->boolean('estado')->default(1);

            // Clave foránea para la ciudad
            $table->unsignedBigInteger('ciudad');
            $table->foreign('ciudad')->references('id')->on('tb_ciudades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_veredas');
    }
}
