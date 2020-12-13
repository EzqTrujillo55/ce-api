<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDireccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('ciudad');
            $table->string('direccion'); 
            $table->string('identificacion');
            $table->string('nombre');
            $table->string('telefono');
            $table->string('email');
            $table->bigInteger('empresa_id')->unsigned()->nullable();
            $table->foreign('empresa_id')->references('id')->on('empresas')
            ->onUpdate('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_direccion');
    }
}
