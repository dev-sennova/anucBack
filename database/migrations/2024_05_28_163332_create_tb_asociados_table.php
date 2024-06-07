<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAsociadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_asociados', function (Blueprint $table) {
            $table->id();
            $table->boolean('estado')->default(1);

            // Clave foránea para personas
            $table->unsignedBigInteger('persona');
            $table->foreign('persona')->references('id')->on('tb_personas');

            // Clave foránea para categoria
            $table->unsignedBigInteger('categoria');
            $table->foreign('categoria')->references('id')->on('tb_categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_asociados');
    }
}
