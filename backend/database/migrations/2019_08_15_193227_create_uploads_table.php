<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
  
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
            $table->integer('curriculos_id')->unsigned()->nullable();
            $table->integer('fisicas_id')->unsigned()->nullable();
            $table->integer('juridicas_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('curriculos_id')->references('id')->on('curriculos')->onDelete('cascade');
            $table->foreign('fisicas_id')->references('id')->on('fisicas')->onDelete('cascade');
            $table->foreign('juridicas_id')->references('id')->on('juridicas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('uploads');
    }
}
