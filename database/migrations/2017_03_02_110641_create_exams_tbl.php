<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateExamsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('exam_name');
            $table->timestamp('start_date');
            $table->timestamp('finish_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('no_of_quest')->length(5);
            #this holds the pass percentage
            $table->integer('pass_percengtage')->length(3);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
        //Schema::dropForeign(['user_id']);
    }
}
