<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('examusers', function(Blueprint $table){
            $table->dropColumn(['av_taken_test', 'results']);
            //$table->bigIncrements('id');
            //$table->string('name')->after;
            $table->string('password')->after('email');
            $table->rememberToken()->after('password');
            //$table->timestamps()->after('rememberToken');

            $table->unique('email');
        });

        //pivot table to hold other results.
        Schema::enableForeignKeyConstraints();
        Schema::create('pivots', function(Blueprint $table){
            $table->bigInteger('examuser_id')->unsigned();
            $table->bigInteger('exam_id')->unsigned();
            $table->integer('results')->default(0);
            $table->smallInteger('av_taken_test')->default(0);

            //foreign
            $table->foreign('examuser_id')->references('id')->on('examusers')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('exam_id')->references('id')->on('exams')->onUpdate('cascade')
                ->onDelete('cascade');

            $table->primary(['examuser_id', 'exam_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidates');
    }
}
