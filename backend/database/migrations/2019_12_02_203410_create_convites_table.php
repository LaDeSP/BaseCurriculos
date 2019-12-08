<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvitesTable extends Migration
{
   
    public function up()
    {
        Schema::create('convites', function (Blueprint $table) {
            $table->increments('id');
            $table->text('resposta')->nullable();
            $table->integer('curriculos_id')->unsigned();
            $table->integer('vagas_id')->unsigned();
            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('curriculos_id')->references('id')->on('curriculos')->onDelete('cascade');
            $table->foreign('vagas_id')->references('id')->on('vagas')->onDelete('cascade');
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('convites');
    }
}
