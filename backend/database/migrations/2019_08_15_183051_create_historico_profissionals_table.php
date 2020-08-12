<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoProfissionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_profissionals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('data_inicial')->nullable();
            $table->date('data_final')->nullable();
            $table->longText('descricao_experiencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_profissionals');
    }
}
