<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoProfissionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_profissionals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('dataInicial')->nullable();
            $table->date('dataFinal')->nullable();
            $table->longText('descricaoExperiencia')->nullable();
            $table->integer('fisicas_id')->unsigned();
            $table->foreign('fisicas_id')->references('id')->on('fisicas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_profissionals');
    }
}
