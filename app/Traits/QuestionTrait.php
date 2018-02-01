<?php

namespace App\Traits;

use App\Question;

trait QuestionTrait{

    /**
     * This returns the questions belonging to an Exam
     * @param int $exam_id
     * @return Collection Question
     */
    public static function getQuestions($exam_id)
    {
        //dd($exam_id);
        $questions = Question::where('exam_id', '=', $exam_id)->get();
        return $questions;
    }


}//end of trait