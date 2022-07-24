<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoAgendaEntrenadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_agenda_entrenador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('date')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('id_usuario')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_usuario')->references('id_user')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_agenda_entrenador');
    }
}
