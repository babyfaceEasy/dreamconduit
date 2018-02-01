<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamUsersTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('examusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->bigInteger('exam_id')->unsigned();
            $table->string('name', 200);
            $table->integer('results')->default('0');
            $table->boolean('av_taken_test');
            $table->timestamps();

            $table->foreign('exam_id')->references('id')->on('exams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_users');
        //Schema::dropForeign(['exam_id']);
    }
}
