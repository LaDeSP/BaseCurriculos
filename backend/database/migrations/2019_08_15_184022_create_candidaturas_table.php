<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vagas_id')->unsigned();
            $table->integer('curriculos_id')->unsigned();
            $table->timestamps();
            $table->foreign('vagas_id')->references('id')->on('vagas')->onDelete('cascade');
            $table->foreign('curriculos_id')->references('id')->on('curriculos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
}
