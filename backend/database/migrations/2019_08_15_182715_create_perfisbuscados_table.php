<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfisbuscadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfisbuscados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('escolaridade');
            $table->string('experiencia');
            $table->integer('idade');
            $table->string('genero');
            $table->string('qualificacoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfisbuscados');
    }
}
