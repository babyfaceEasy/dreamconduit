<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
    	'id',
    	'exam_name',
    	'start_date',
    	'finish_date',
    	'no_of_quest',
    	'pass_percengtage',
    	'user_id',
    	'time',
        'instruction'
    ];
}
