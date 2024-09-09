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
            $table->longText('imagenProducto')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('estado')->default(1);
            $table->boolean('telefono_visible')->default(1);
            $table->string('telefono')->nullable();
            $table->boolean('whatsapp_visible')->default(1);
            $table->string('whatsapp')->nullable();
            $table->boolean('correo_visible')->default(1);
            $table->string('correo')->nullable();
            $table->integer('cantidad');
            $table->decimal('precio');
            $table->string('descripcion');


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
