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
            $table->string('tipoVaga');
            $table->string('local');
            $table->string('salario');
            $table->string('beneficio');
            $table->string('quantidade_horas');
            $table->integer('juridicas_id')->unsigned();
            $table->integer('areas_id')->unsigned();
            $table->integer('perfisbuscados_id')->unsigned();

            $table->timestamps();

            $table->foreign('juridicas_id')->references('id')->on('juridicas')->onDelete('cascade');
            $table->foreign('areas_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('perfisbuscados_id')->references('id')->on('perfisbuscados')->onDelete('cascade');
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
