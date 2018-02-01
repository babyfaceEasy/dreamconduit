<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamUser extends Model
{
    protected $fillable = ['email', 'name', 'results', 'av_taken_test', 'exam_id'];
    protected $table = 'examusers';

    //this is to get the exam attributed with this user
    public function exam()
    {
    	return $this->belongsTo(Exam::class);
    }
}
