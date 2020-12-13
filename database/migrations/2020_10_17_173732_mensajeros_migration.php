<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MensajerosMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensajeros', function (Blueprint $table) {
            $table->id();
            $table->string('cedula');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email');
            $table->string('telefono');
            $table->string('tipoVehiculo');
            $table->string('descripcionVehiculo');
            $table->string('placaVehiculo');
            $table->string('colorVehiculo');
            $table->string('status');
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
        //
    }
}
