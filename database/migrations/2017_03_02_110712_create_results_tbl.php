<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('examusers_id')->unsigned();
            $table->text('answers');
            $table->boolean('passed');
            $table->timestamps();


            $table->foreign('examusers_id')->references('id')->on('examusers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
        //Schema::dropForeign(['exam_users_id']);
    }
}
