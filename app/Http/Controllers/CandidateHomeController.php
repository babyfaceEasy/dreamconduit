<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Traits\ExamTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateHomeController extends Controller
{
    use ExamTrait;
    public function __construct()
    {
        $this->middleware('auth:candidate');
    }

    public function examListDT()
    {
        //getting back a datatable here
        $examsDT = ExamTrait::candidateExamList(Auth::guard('candidate')->user()->id);

        $examsDT->editColumn('exam_id', function ($data){
            return $data->exam->exam_name;
        });
        $examsDT->addColumn('action', function ($data){
            $ret = '';

            if ( (time() - strtotime($data->exam->finish_date)) > 0 ){
                //hence the finished date has gone
                $ret .= '<span style="font-size: " class="label label-danger">Exam Closed</span> ';
            }else{
                $ret .= '<span style="font-size: " class="label label-default">Exam Open</span> ';
            }
            if( $data->av_taken_test == 1 ){
                $ret .= '<span style="font-size: 16px;" class="label label-info">Exam Taken</span> ';
            }

            if( (time() - strtotime($data->exam->finish_date)) < 0 & $data->av_taken_test == 0)
            {
                $ret .= '<a href="'. route('instruction.page', ['exam_id' => $data->exam_id]).'" class="btn btn-success btn-md">Take Exam  <i class="fa fa-arrow-right" aria-hidden="true"></i></a>';
            }
            return $ret;
        });

        return $examsDT->make(true);
    }

    public function index()
    {
        return view('candidate.home');
    }

    public function instructionPage($exam_id)
    {

        $exam_data = Exam::find($exam_id);

        return view('candidate.instruction', compact('exam_data'));
    }

    public function showTest(Request $request  )
    {
        return view('candidate.test');
    }
}
