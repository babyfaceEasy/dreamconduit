<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddforeignKeyPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pivots', function (Blueprint $table) {
            $table->dropForeign(['examuser_id']);
        });
        Schema::table('pivots', function (Blueprint $table) {
            $table->foreign('examuser_id')->references('id')->on('candidates')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivots', function (Blueprint $table) {
            //
        });
    }
}
