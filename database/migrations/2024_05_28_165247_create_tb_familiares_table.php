<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_familiares', function (Blueprint $table) {
            $table->id();
            $table->boolean('estado')->default(1);

            // Clave foránea para asociados
            $table->unsignedBigInteger('asociado');
            $table->foreign('asociado')->references('id')->on('tb_asociados');

            // Clave foránea para personas
            $table->unsignedBigInteger('persona');
            $table->foreign('persona')->references('id')->on('tb_personas');

            // Clave foránea para producto parentesco
            $table->unsignedBigInteger('parentesco');
            $table->foreign('parentesco')->references('id')->on('tb_parentescos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_familiares');
    }
}
