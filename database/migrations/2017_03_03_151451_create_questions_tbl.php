<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exam_id')->unsigned();
            $table->text('question');
            $table->string('option_a', 200);
            $table->string('option_b', 200);
            $table->string('option_c', 200);
            $table->string('option_d', 200);
            $table->string('correct_ans', 200);
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
        Schema::dropIfExists('questions');
    }
}
