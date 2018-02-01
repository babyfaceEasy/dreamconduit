<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('exams')->insert([
        	'user_id' => '4',
        	'exam_name' => 'HR Recruiting',
        	'start_date' => '2017-03-02 16:57:30',
        	'finish_date' => '2017-04-02 16:57:30',
        	'no_of_quest' => '20',
        	'pass_percengtage' => '40'
        ]);
    }
}
