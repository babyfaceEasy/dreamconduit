<?php

namespace App\Traits;

use App\Pivot;
use DB;
use App\Exam;
use Yajra\Datatables\Datatables;


trait ExamTrait{

    /**
     * This returns datatables of all the data in the examination table.
     * NB: this doesn't set the make(true) of Datatables, the calling func has to set it.
     * @req Datatables, DB, Exam
     *
     * @return datatables object
     */
    public function examDataDT()
    {
        DB::statement(DB::raw('set @rownum:=0'));
        $exams_dt =  Exam::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'id',
            'exam_name',
            'start_date',
            'finish_date',
            'no_of_quest'
        ]);

        return \Yajra\Datatables\Datatables::of($exams_dt);

    }//end of func

    /**
     * This returns the list of exams for a particular candidate
     * @param int $candidate_id
     * 
     * @return Datatable Object
     */
    public static function candidateExamList($candidate_id)
    {
        //IDEA : select all the exam_ids from the pivot table where candidate id = id
        DB::statement(DB::raw('set @rownum:=0'));
        $exams = Pivot::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'examuser_id',
            'exam_id',
            'results',
            'av_taken_test'
        ])->where('examuser_id', $candidate_id)->get();

        return Datatables::of($exams);
    }

    /**
     * This is to return the required instruction
     * @param int $exam_id
     * @return Exam eloquent
     */
    public static function examInstruction($exam_id)
    {
        $ret = Exam::find($exam_id);
        return $ret;
    }

    public static function isExamOpen($exam_id)
    {
        $curr_time = time();
        $exam = Exam::find($exam_id);
        if( $exam == null ) return false;
        $finish_date =  $exam->finish_date;
        $finish_time = strtotime($finish_date);

        if($curr_time - $finish_time > 0){
            return false;
        }else{
            return true;
        }
    }



}//end of trait