<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Exam;
use Session;
use DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($exam_id)
    {
        //this is to get the number of questions already added
        $exam = Exam::find($exam_id);
        $questions = Question::where('exam_id', $exam_id)->get();
        $avail_quests = Question::where('exam_id', $exam_id)->count();

        if($exam->no_of_quest == $avail_quests)
        {
            Session::flash('err_msg', 'You have no more slots to add questions.');
            //return redirect()->back();
        }

        return view ('question.create', ['exam_id' => $exam_id, 'total_quest' => $exam->no_of_quest, 'avail_quests' => $avail_quests, 'quests' => $questions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            //'option_c' => 'required|string',
            //'option_d' => 'required|string',
            'correct_ans' => 'required|string',
            'exam_id' => 'required'
        ]);

        $exam = Exam::find($request->input('exam_id'));
        $avail_quests = Question::where('exam_id', $request->input('exam_id'))->count();

        if($exam->no_of_quest == $avail_quests)
        {
            Session::flash('err_msg', 'You have no more slots to add questions.');
            return redirect()->back();
        }

        $input = $request->only('question', 'option_a', 'option_b', 'option_c', 'option_d', 'exam_id', 'correct_ans');

        $ret = Question::create($input);

        if(is_null($ret))
        {
            //set error message and redirect to list of exams 
            //TODO: log error
            Session::flash('err_msg', 'An error occurred, please try again later.');
            return redirect()->back();
        }else
        {
            //set success message and redirect to add page
            Session::flash('suc_msg', 'Question has been added.');
            return redirect()->route('quest.index', ['exam_id' => $request->exam_id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //this performs the update action
        $this->validate($request, [
            'question' => 'required',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            //'option_c' => 'required|string',
            //'option_d' => 'required|string',
            'correct_ans' => 'required|string',
            'exam_id' => 'required'
        ]);

        $input = $request->only('question', 'option_a', 'option_b', 'option_c', 'option_d', 'exam_id', 'correct_ans');

        try {
            $ret = Question::findOrFail($id)->update($input);

        } catch (Exception $e) {
            //TODO: log the error
        }
        
        //$ret = Question::update($input);

        if(is_null($ret))
        {
            //set error message and redirect to list of exams 
            //TODO: log error
            Session::flash('err_msg', 'An error occured, please try again later.');
            return redirect()->back();
        }else
        {
            //set success message and redirect to add page
            Session::flash('suc_msg', 'Question update was sucessful.');
            return redirect()->route('quest.index', ['exam_id' => $request->exam_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //this deletes the question out of the bank
        try {
            $question = Question::findOrFail($id);
        } catch (Exception $e) {
            //TODO:log correct error
        }

        if ($question->delete()) {
            Session::flash('suc_msg', 'Question delete operation was successful.');
            return redirect()->back();
        }else{
            Session::flash('err_msg', 'An error occured, please try again later.');
            return redirect()->back();
        }
    }
}
