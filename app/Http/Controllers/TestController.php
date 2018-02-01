<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamUser;
use App\Exam;
use Session;
use App;
use App\Question;
use Cookie;

class TestController extends Controller
{
	protected function checker(Request $request)
	{
		if(empty($_SESSION['client_email']) && empty($_SESSION['client_name'])){
            //App::abort(404);
			return view('welcome');
		}

        //this is to check if u av taken the exams
        $email = $request->session()->get('client_email');
        $candidate = ExamUser::where('email', $email)->first();
        if($candidate->av_taken_test != 0){
            Session::flash('err_msg', 'You have already taken this test');
            return route('welcome');
        }

        $exam = Exam::find($candidate->exam_id);
        $curtime = time();
        $time = strtotime($exam->finish_date);

        //dd($time);

        if ($curtime - $time  > 1800){
            Session::flash('err_msg', 'This examination has been taken down.');
            return redirect()->route('welcome');
        }
	}
    public function getQuestionData(Request $request)
    {
    	$this->checker($request);

        //this is to check if u av taken the exams
        $email = $request->session()->get('client_email');
        $candidate = ExamUser::where('email', $email)->first();
        if($candidate->av_taken_test != 0){
            Session::flash('err_msg', 'You have already taken this test');
            return route('welcome');
        }

        $exam = Exam::find($candidate->exam_id);
        $curtime = time();
        $time = strtotime($exam->finish_date);

        //dd($time);

        if ($curtime - $time  > 1800){
            Session::flash('err_msg', 'This examination has been taken down.');
            return redirect()->route('welcome');
        }


    	//$email = $request->session()->get('client_email');
    	$client = ExamUser::where('email', $email)->first();

    	//TODO:effect this code during UAT
    	//this is to set the taken test to one
    	

    	$client->av_taken_test = 1;
    	$client->save();


    	//this select all question for this user
    	$exam = Exam::find($client->exam_id);
    	$questions = Question::where('exam_id', $exam->id)->get();


        //this session to show if there are no values
        
        //$t = date("Y/m/d h:i:s", strtotime("now"));
        //$dt = date("M d, Y H:i:s", strtotime("+1 hour 1 Minutes"));
        $dt = date("M d, Y H:i:s", strtotime("+1 Hour ".$exam->time." Minutes"));
        
        if($request->session()->has('countdown_timer')){
            //return $response;
        }else{
            $request->session()->put('countdown_timer', $dt);
            //return $response;
        }
        return view('exam_user.test ', ['questions' => $questions, 'exam' => $exam]);
    }

    public function updateTimer(Request $request, $val){
        $request->session()->put('countdown_timer', $val);
    }

    public function calculateResult(Request $request)
    {
    	$this->checker($request);
    	//dd($request->input('question_1'));
    	//this calculates the result of the users input
    	$score = 0;
    	$passed = 0;
    	$failed = 0;
    	$candidate = ExamUser::where('email', $request->session()->get('client_email'))->first();
    	$exam = Exam::find($request->input('exam_id'));
    	$questions = Question::where('exam_id', $request->input('exam_id'))->get();
    	$counter = 1;
    	foreach ($questions as $question) {
    		#$question_req = 'question_'.$question->id;
    		if( strtolower($question->correct_ans) == strtolower($request->input('question_'.$question->id)) )
    		{
    			$score++;
    			$passed++;
    		}else
    		{
    			$failed++;
    		}
    	}

    	//here we are to calculate the pass percentage
    	#score/totoal * 100
    	$percent = ($score/$questions->count()) * 100;
		//set the database column for the exam user to either scored or failed
		//also set taken test to 1
		$candidate->av_taken_test =  1;
		$candidate->results = $percent;

		$candidate->save();

    		//this is to save fill the results table
    	/*if($percent >= $exam->pass_percengtage)
    	{
    				
    	}*/

    	return view('exam_user.results', ['percent' => $percent, 'score' => $score, 'failed' => $failed, 'tot_quests' => $questions->count()]);
    	//dd($percent);
    }//end of calculate result
}//end of class
