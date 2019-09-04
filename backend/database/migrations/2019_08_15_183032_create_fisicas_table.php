<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFisicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('genero');
            $table->date('data_nascimento');
            $table->integer('contatos_id')->unsigned();
            $table->integer('enderecos_id')->unsigned();
            $table->timestamps();
            $table->foreign('contatos_id')->references('id')->on('contatos')->onDelete('cascade');
            $table->foreign('enderecos_id')->references('id')->on('enderecos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fisicas');
    }
}
