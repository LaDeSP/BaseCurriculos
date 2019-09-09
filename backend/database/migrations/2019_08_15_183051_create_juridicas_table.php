<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuridicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juridicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj')->unique();
            $table->string('ramo');
            $table->string('trabalheConoscoURL')->nullable();
            $table->integer('contatos_id')->unsigned()->nullable();
            $table->integer('enderecos_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('juridicas');
    }
}
