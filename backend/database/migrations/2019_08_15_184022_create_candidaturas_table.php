<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaturasTable extends Migration
{
   
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vagas_id')->unsigned();
            $table->integer('curriculos_id')->unsigned();
            $table->string('status');
            $table->timestamps();
            $table->foreign('vagas_id')->references('id')->on('vagas')->onDelete('cascade');
            $table->foreign('curriculos_id')->references('id')->on('curriculos')->onDelete('cascade');

        });
    }

  
    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
}
