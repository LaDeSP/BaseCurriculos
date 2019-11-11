<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data');
            $table->time('hora');
            $table->string('observacao')->nullable();
            $table->string('contraproposta')->nullable();
            $table->timestamps();

            $table->integer('candidatura_id')->unsigned();
            $table->foreign('candidatura_id')->references('id')->on('candidaturas');
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('agendas');
    }
}
