<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJuridicasTable extends Migration
{
   
    public function up()
    {
        Schema::create('juridicas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj')->unique();
            $table->integer('contatos_id')->unsigned()->nullable();
            $table->integer('enderecos_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->softDeletes();
            $table->unsignedInteger('areas_id');
            $table->foreign('areas_id')->references('id')->on('areas');
            $table->foreign('contatos_id')->references('id')->on('contatos')->onDelete('cascade');
            $table->foreign('enderecos_id')->references('id')->on('enderecos')->onDelete('cascade');
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('juridicas');
    }
}
