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
            $table->string('cpf')->unique();
            $table->string('genero')->nullable();
            $table->string('estado_civil')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->integer('contatos_id')->unsigned()->nullable();
            $table->integer('enderecos_id')->unsigned()->nullable();
            $table->timestamps();

            
            $table->softDeletes();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('contatos_id')->references('id')->on('contatos');
            $table->foreign('enderecos_id')->references('id')->on('enderecos');
         
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
