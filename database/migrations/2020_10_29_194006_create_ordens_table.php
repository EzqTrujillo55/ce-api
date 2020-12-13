<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->string('tipoServicio');
            $table->double('peso');
            $table->integer('numGestiones');
            $table->string('origen');
            $table->string('ciudadOrigen');
            $table->string('dirOrigen');
            $table->string('remitente');
            $table->string('telRemitente');
            $table->string('destino');
            $table->string('ciudadDestino');
            $table->string('dirDestino');
            $table->string('destinatario');
            $table->string('telDestinatario');
            $table->string('detalle');
            $table->bigInteger('mensajero_id')->unsigned()->nullable();
            $table->bigInteger('ruta_id')->unsigned()->nullable(); 
            $table->timestamps();
            $table->foreign('mensajero_id')->references('id')->on('mensajeros')
            ->onDelete('SET NULL')
            ->onUpdate('CASCADE');
            $table->foreign('ruta_id')->references('id')->on('rutas')
            ->onDelete('SET NULL')
            ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes');
    }
}
