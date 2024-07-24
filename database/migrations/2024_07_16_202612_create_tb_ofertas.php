<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbOfertas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ofertas', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('estado')->default(1);
            $table->boolean('contacto_visible')->default(1);
            $table->integer('cantidad');


            // Clave foránea para productos
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('tb_productos');

            // Clave foránea para Asociados fincas
            $table->unsignedBigInteger('asociados_finca_id');
            $table->foreign('asociados_finca_id')->references('id')->on('tb_asociados_fincas');

            // Clave foránea para Unidad de Medida
            $table->unsignedBigInteger('medida_unidades_id');
            $table->foreign('medida_unidades_id')->references('id')->on('tb_medida_unidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ofertas');
    }
}
