<?php
//Youtube page : The Net Ninja
//Youtube: devGeek


namespace App\Traits;

use App\Http\Utils\RandomStringGenerator;
use Excel;
use DB;
use App\Candidate;
use App\Pivot;
use Yajra\Datatables\Datatables;
use Illuminate\Database\QueryException;

trait CandidateTrait{
    /*
     * This resets a given candidate
     * sets the taken exam to false and the score to 0
     *
     * @param $candidate_id  The unique identifier of the candidate
     * @param $exam_id The unique identifier of the exam the candidate is connected to
     * @return boolean true/false
     *
     */
    public static function resetCandidate($candidate_id, $exam_id)
    {
        //$exam_id = 1;
        //dump($exam_id);
        //IDEA: this checks the pivot table and selects where candidat_id and exam_id matches
        //then sets examuser_id & exam_id to 0
        // input array
        $input = ['results' => 0, 'av_taken_test' => 0];

        $ret = DB::table('pivots')
            ->where('examuser_id', $candidate_id)
            ->where('exam_id', $exam_id)
            ->update($input);

        return ($ret == 0)? false : true;

    }//end of func

    /*
     * This is to delete the candidate from a particular exam.
     *
     * @param int $candidate_id
     * @param int $exam_id
     * @return bool
     */
    public static function deleteCandidate($candidate_id, $exam_id)
    {
        //IDEA: this is to delete the user from the current exam.

        $ret = DB::table('pivots')->where('examuser_id', $candidate_id)->where('exam_id', $exam_id)->delete();

        return $ret;
    }

    /*
     * This is to add candidates from the excel file to the database and also generate
     * passwords.
     *
     * @param String $filename
     * @param int $exam_id
     *
     * @return true/false
     */
    public static function uploadNames($file_name, $exam_id)
    {
        $ret_val = false;

        $destination_path = storage_path() .'/app/public/'.$file_name;
        $rows = Excel::load($destination_path)->get();

        //inside here nau, we can loop through and save into the databases
        //nb: here, we need to save the data inside two tables
        //1=> the candidates table for login
        //=>pivots table for exam info
        $candid_input = array();

        //this is to generate their passwords
        $generator = new RandomStringGenerator();

        //also note that, we have to check if the email exist no need of adding it to candidate table.
        //just go straight to the pivots table and add

        foreach ($rows as $row) {
            //dump($r->emails);
            $candidate = Candidate::where('email', '=', $row->emails)->first();
            //this is the email check area
            if ( $candidate === null ){
                //email not found
                $pwd = $generator->generate(8);
                $candid_input['email'] = $row->emails;
                $candid_input['name'] = $row->names;
                $candid_input['password'] = bcrypt($pwd);
                $candid_input['unique_key'] = $pwd;

                //this is to save into the db
                $candidate = Candidate::create($candid_input);

                //here just add the person to pivot table
                $pivot_input = ['examuser_id' => $candidate->id, 'exam_id' => $exam_id, 'results' => 0, 'av_taken_test' => 0];
                $ret = Pivot::create($pivot_input);
                if($ret !== null)
                    $ret_val = true;
            }
        }

        return $ret_val;
    }

    /*
     * This adds candidate to both the candidate table and pivots table
     * @param String $email the email of the candidate to add
     * @param String $name the name of the candidate
     * @param int $exam_id the identifier for the particular exam
     *
     * @return bool
     */
    public static function addCandidate($email, $name, $exam_id)
    {
        $candidate = Candidate::where('email', '=', $email)->first();
        if($candidate === null){
            //email not found
            $generator = new RandomStringGenerator();
            $pwd = $generator->generate(8);

            $input = ['email' => $email, 'unique_key' => $pwd, 'password' => bcrypt($pwd), 'name' => $name];

            $candidate = Candidate::create($input);
        }

        //this is to update pivot
        $input = ['examuser_id' => $candidate->id, 'exam_id' => $exam_id, 'results' => 0, 'av_taken_test' => 0];
        /*try{
            $ret = Pivot::create($input);
        }catch (QueryException $e){
            //TODO: log $e error
        }*/
        $ret = Pivot::create($input);
        return $ret;

        /*if($ret === null){
            return true;
        }else
            return false;*/
    }// end of addCandidate()

    /*
     * This is to get all the candidates for a particular exam
     *
     * @param int $exam_id the examination identifier
     *
     * @return Datatables object
     */
    public static function specificCandidatesDT($exam_id)
    {
        $candidates = Pivot::where('exam_id', $exam_id)->get();

        //dd($candidates->get(0)->candidate);

        $datatables = Datatables::of($candidates);

        return $datatables;
    }

    /*
     * This is to clear an exam of all candidates.
     * @param int $exam_id the examination identifier
     *
     * @return bool
     */
    public static function clearCandidates($exam_id)
    {
        $ret = DB::table('pivots')->where('exam_id', '=', $exam_id)->delete();

        return $ret;
    }

    /*
     * This is to returns a list for results
     *
     */
    public static function candidatesExamResultsDT($exam_id)
    {
        DB::statement(DB::raw('set @rownum:=0'));
        $candidates =  Pivot::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'examuser_id',
            'exam_id',
            'results',
            'av_taken_test',
            'created_at',
            'updated_at',
        ])->where('exam_id', $exam_id);
        //dd($candidates);

        return Datatables::of($candidates);
    }
    /*
     * This exports the results for a particular exam
     * @param int $exam_id
     *
     * @return Collection
     */
    public static function allResultsForExam($exam_id)
    {
        $results = DB::table('pivots')->where('exam_id', '=', $exam_id)->get();

        return $results;
    }

    /**
     * This checks if a user has taken a test
     * @param int $candidate_id
     * @param int $exam_id
     *
     * @return bool
     */
    public static function avTakenTest($candidate_id, $exam_id)
    {
        $pivot = Pivot::where('exam_id', $exam_id)->where('examuser_id', $candidate_id)->first();

        if($pivot->av_taken_test == 1)
            return true;
        return false;
    }

    /**
     * This sets the avTakentest column to 1
     * @param int $candidate_id : Candidate's identifier
     * @param int $exam_id : Exam's identifier
     *
     * @return bool
     */
    public static function setTakenTest($candidate_id, $exam_id)
    {
        $pivot = Pivot::where('exam_id', $exam_id)->where('examuser_id', $candidate_id)->first();
        $ret = Pivot::where('exam_id', $exam_id)->where('examuser_id', $candidate_id)->update(['av_taken_test' => 1]);

        if($ret == 0)
            return false;
        else
            return true;

    }

}//end of trait
