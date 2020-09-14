<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurriculosTable extends Migration
{
   
    public function up()
    {
        Schema::create('curriculos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('objetivos');
            $table->string('pretensao');
            $table->string('escolaridade');
            $table->string('curso')->nullable();
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('instituicao')->nullable();

            $table->string('qualificacoes');
            $table->string('historicoProfissional');
            $table->integer('fisicas_id')->unsigned();
            $table->integer('areas_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('fisicas_id')->references('id')->on('fisicas')->onDelete('cascade');
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
        Schema::dropIfExists('curriculos');
    }
}
