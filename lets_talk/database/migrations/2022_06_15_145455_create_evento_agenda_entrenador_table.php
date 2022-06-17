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
            $table->string('description')->nullable();
            $table->boolean('all_day');
            $table->string('start_date', 50);
            $table->string('start_time', 30)->nullable();
            $table->string('end_date', 50);
            $table->string('end_time', 30)->nullable();
            $table->string('color')->nullable();
            $table->boolean('status_busy');
            $table->boolean('status_free');
            $table->boolean('state')->default(1);
            $table->integer('id_usuario')->unsigned();
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
