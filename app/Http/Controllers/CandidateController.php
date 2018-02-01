<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Pivot;
use App\Traits\CandidateTrait;
use App\Traits\ExamTrait;
use App\Traits\QuestionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class CandidateController extends Controller
{
    use QuestionTrait;
    public function __construct()
    {
        $this->middleware('auth:candidate');
    }

    public function getQuestionData(Request $request)
    {


        //what this function does is that it saves to session the exam id
        //then set the taken exam to 1
        //then shows the exam page wiv all question

        //this get the previous url breaks it into an array and saves
        //it inside a session
        $prev_url = URL::previous();
        $arr_url = explode('/', $prev_url);
        $exam_id = end($arr_url);

        session(['exam_id' => $exam_id]);

        //get the questions from QuestionTrait
        $exam_id = session('exam_id');
        $questions = QuestionTrait::getQuestions($exam_id);
        $exam = Exam::find($exam_id);

        //confirm that the exam is opened
        if(ExamTrait::isExamOpen($exam_id) == false){
            Session::flash('err_msg', 'This examination is closed.');
            return redirect('candidate/home');
        }

        //confirm that user has not taken the test
        if(CandidateTrait::avTakenTest(Auth::user()->id, $exam_id))
        {
            Session::flash('err_msg', 'You have already taken this test.');
            return redirect('candidate/home');
        }

        //TODO:effect this code during UAT
        //this is to set the taken test to one
        if(CandidateTrait::setTakenTest(Auth::user()->id, $exam_id) == false){
            Session::flash('err_msg', 'An error occurred, please try again later.');
            //TODO: log error
            return redirect('candidate/home');
        }

        $request->session()->forget('exam_id');

        //$dt = date("M d, Y H:i:s", strtotime("+1 hour 1 Minutes"));
        $dt = date("M d, Y H:i:s", strtotime("+1 Hour ".$exam->time." Minutes"));

        //$response = new \Illuminate\Http\Response();
        if ($request->session()->has('countdown_timer') == false){
            $request->session()->put('countdown_timer', $dt);
        }
        return view('candidate.test ', ['questions' => $questions, 'exam' => Exam::find($exam_id)]);
    }

    public function calculateResult(Request $request)
    {
        //this is to calculate the result.
        $score = 0;
        $passed = 0;
        $failed = 0;

        $exam = Exam::find($request->input('exam_id'));
        $questions = QuestionTrait::getQuestions($exam->id);
        foreach ($questions as $question){
            if(strtolower($question->correct_ans) == strtolower($request->input('question_'.$question->id))){
                $score++;
                $passed++;
            }
            else
            {
                $failed++;
            }
        }

        //here is to calculate percentage
        $percent = ($score/$questions->count()) * 100;

        //set taken to 1
        //set results to percentage
        $pivot = Pivot::where('examuser_id', Auth::user()->id)->where('exam_id', $exam->id)->first();
        Pivot::where('examuser_id', Auth::user()->id)->where('exam_id', $exam->id)->update(['results' => $percent, 'av_taken_test' => 1]);
        /*$pivot->results = $percent;
        $pivot->av_taken_test = 1;
        $pivot->save();*/

        return view('candidate.results', ['percent' => $percent, 'score' => $score, 'failed' => $failed, 'tot_quests' => $questions->count()]);
    }//end of calculateResult()
}
