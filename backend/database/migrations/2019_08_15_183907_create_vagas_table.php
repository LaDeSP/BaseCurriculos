<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVagasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('local');
            $table->string('salario');
            $table->string('beneficio');
            $table->string('jornada');
            $table->string('requisito');
            $table->integer('juridicas_id')->unsigned();
            $table->integer('areas_id')->unsigned();
          
            $table->timestamps();

            $table->foreign('juridicas_id')->references('id')->on('juridicas')->onDelete('cascade');
            $table->foreign('areas_id')->references('id')->on('areas')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vagas');
    }
}
