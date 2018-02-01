<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pivot extends Model
{
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = ['examuser_id', 'exam_id', 'results', 'av_taken_test'];

    //relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'examuser_id');
    }
}
