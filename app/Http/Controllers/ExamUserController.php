<?php

namespace App\Http\Controllers;

use App\Traits\CandidateTrait;
use Illuminate\Http\Request;
use DB;
use App\Candidate;
use App\Exam;
use App\ExamUser;
use Excel;
use Session;
use Datatables;

class ExamUserController extends Controller
{
    use CandidateTrait;
    public function __construct()
    {
    	$this->middleware('auth', ['except' => [
            'candidateLogin',
            'clientLoginPage',
            'clientInfoPage',
            'candidateLogin',
            'candidateLogout',
            'candidateListOfExams'
        ]]);
    }

    public function index(Request $request, $exam_id)
    {
    	$exam = Exam::find($exam_id);
    	return view('exam_user.create', ['exam_id' => $exam_id]);
    }

    //this returns sample file for the batch upload format
    public function sampleExcelDownload(Request $request)
    {
      return response()->download(public_path('templates/candidates-batch-upload.xlsx'));
    }

    public function store(Request $request)
    {
    	//dd($request);
        if($request->has('type') && $request->input('type') == 'single'){
            $this->validate($request, [
                'email' => 'required|email',
                'name' => 'required|min:3'
            ]);
        }else{
           $this->validate($request, [
                'names_excel' => 'required|file'
            ]);
        }

        if($request->has('type') && $request->input('type') == 'group'){
           //upload into public folder
            $file = $request->file('names_excel');
            $destination_path = storage_path() .'/app/public/';
            $file->move($destination_path, $file->getClientOriginalName());

            //$this->testExcel($file->getClientOriginalName(), $request->exam_id);

            $val = CandidateTrait::uploadNames($file->getClientOriginalName(), $request->exam_id);

            if( $val )
                Session::flash('suc_msg', 'Upload was successful!');
            else
                Session::flash('err_msg', ' Some names didn\'t register, please check to confirm');
                //return redirect()->back();
        }else{
            //$input = $request->only('name', 'email', 'exam_id');
            //$ret = ExamUser::create($input);
            $ret = CandidateTrait::addCandidate($request->input('email'), $request->input('name'), $request->input('exam_id'));

            if(is_null($ret)){
                Session::flash('err_msg', 'An error occurred, please try again later.');
            }else{
                Session::flash('suc_msg', 'User addition to test was successful !!');
            }
        }
        return redirect()->back();
    }

    public function  destroy(Request $request, $id)
    {
        //for deleting a particular user
        $ret = CandidateTrait::deleteCandidate($id, $request->input('exam_id'));

        if($ret){
            return response()->json([
                'success' => 'Candidate has been deleted successfully from this Exam.'
            ]);
        }

        return response()->json([
            'success' => 'This particular user doesn\'t exist for the Exam.'
        ]);
    }

    /**
     * Removes all the candidates attaches to the exam_id
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function clearAllCandidates(Request $request)
    {
        /*$candidates_ids = ExamUser::where('exam_id', $request->input('exam_id'))->pluck('id')->toArray();

        if (empty($candidates_ids)){
            Session::flash('suc_msg', 'There exist no candidates to delete.');
            return redirect()->back();
        }

        try{
            ExamUser::destroy($candidates_ids);
        }catch (\ModelNotFoundException $e){

            Log::error($e->getMessage());
            Session::flash('err_msg', 'An error occurred, while trying to delete candidates. Please try again later.');
            return redirect()->back();
        }catch (\QueryException $e){

            Log::error($e->getMessage());
            Session::flash('err_msg', 'An error occurred, while trying to delete candidates. Please try again later.');
            return redirect()->back();
        }*/

        $ret = CandidateTrait::clearCandidates($request->input('exam_id'));
        if ($ret)
        {
            Session::flash('suc_msg', 'All candidates have been cleared.');
        }else{
            Session::flash('err_msg', 'An error occurred, while trying to delete candidates. Please try again later.');
        }

        //assuming all went well return to the main page with success
        //Session::flash('suc_msg', 'All candidates have been cleared.');
        return redirect()->back();


    }

    public function resetCandidate(Request $request, $id)
    {
        //dd($request->input('exam_id'));

        //this is to set the taken_test to 1 and score to 0
        $ret = CandidateTrait::resetCandidate($id, $request->input('exam_id'));

        return response()->json([
            'success' => 'Reset operation was successfully'
        ]);

        /*if($ret)
        {
            return response()->json([
                'success' => 'Reset operation was successfully'
            ]);
        }else{
            return response()->json([
                'success' => 'Reset operation was not successfully'
            ]);
        }*/
    }//end of resetCandidate

    public function edit($id)
    {
        //dd($request);
        $candidate =  Candidate::find($id);
        return view('exam_user.edit', compact('candidate'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'email' => 'required|email',
            'name' => 'required|min:3'
        ]);

        //after val
        $input = $request->only('email', 'name');

        //update the db
        $candidate = Candidate::findOrFail($id);
        $ret = $candidate->update($input);
        if(is_null($ret))
        {
            Session::flash('err_msg', 'An error occurred, please try again later.');
            return redirect()->back();
        }else
        {
            Session::flash('suc_msg', 'Candidate update operation was successful');
            return redirect()->back();
            //return redirect()->route('candidates.index', $candidate->exam_id);
        }
    }

    protected function testExcel($file_name, $exam_id)
    {
    	//TODO: look for a way for this function to return
    	//success / failure. Depending on what happens

    	$destination_path = storage_path() .'/app/public/'.$file_name;
    	$rows = Excel::load($destination_path)->get();

    	//inside here nau, we can loop through and save into the databases
    	$input = array(
    		'exam_id' => $exam_id,
    	);

        //dd($rows);
    	foreach ($rows as $row) {
    		//dump($r->emails);
    		$input['email'] = $row->emails;
    		$input['name'] = $row->names;

    		//this is to save into the db
    		$ret = ExamUser::create($input);
    	}
    	//dd($row);
    }

    #this shows all the candidates attached to a particular exam_id
    public function viewList($exam_id)
    {
    	/*$candidates = ExamUser::where('exam_id', $exam_id)->get();
    	dd($candidates);*/
    	return view('exam_user.index');
    }

    protected function checker(Request $request)
    {
        if(empty($_SESSION['client_email']) && empty($_SESSION['client_name'])){
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

    public function clientLoginPage()
    {
    	return view('welcome');
    }

    public function clientInfoPage(Request $request)
    {
        $this->checker($request);
        return view('exam_user.info');
    }

    //this handles login
    public function candidateLogin(Request $request)
    {
    	//dd($request);
    	$this->validate($request, [
    		'email' => 'required|email'
    	]);

    	//perform the check
    	//check to see if the email exists in the db and av_taken == 0
    	$candidate =  ExamUser::where('email', $request->input('email'))->first();
    	if(is_null($candidate)){
    		Session::flash('err_msg', 'You are not allowed on this application.');
    		return redirect()->route('client.login.page');
    	}else{
    		if($candidate->av_taken_test != 0){
    			Session::flash('err_msg', 'You have already taken this test.');
    			return redirect()->route('client.login.page');
    		}else
    		{
    			//go to the show me page
    			//and set the
    			$request->session()->put('client_name', $candidate->name);
    			$request->session()->put('client_email', $candidate->email);


                $exam = Exam::find($candidate->exam_id);
                $curtime = time();
                $time = strtotime($exam->finish_date);

                if ($curtime - $time  > 1800){
                    Session::flash('err_msg', 'Pleas note that this examination is closed.');
                    return redirect()->route('welcome');
                    //return redirect()->route('client.logout');
                }

                if ($candidate->av_taken_test != 0){
                    Session::flash('err_msg', 'You have already taken this test.');
                    return redirect()->route('welcome');
                    //return redirect()->route('client.logout');
                }
                //go to the info page
                //shows list of all exams for the particular user
                //return redirect()->route('candidates.exam.list');
                return view('exam_user.info', ['exam' => $exam, 'candidate' =>$candidate]);

    		}
    	}
    }//end candidateLogin

    public function candidateListOfExams(Request $request)
    {
        $this->checker($request);
        return view('exam_user.exam_list');
    }

    public function candidateListOfExamsData(Request $request)
    {

        //this returns all the exam names for the particular user
        //dd($request->session()->get('client_email'));
        DB::statement(DB::raw('set @rownum:=0'));
        $exams =  ExamUser::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'id',
            'email',
            'exam_id',
            'name',
            'results',
            'av_taken_test'
        ])->where('email', $request->session()->get('client_email'));
        //$exams = ExamUser::where('email', $request->session()->get('client_email'))->get();
        //dd($exams[0]->exam->exam_name);
        $examsDatatables = Datatables::of($exams);
        $examsDatatables->editColumn('exam_id', function($examData){
            return $examData->exam->exam_name;
        });
        $examsDatatables->addColumn('time', function($examData){
            return $examData->exam->time;
        });
        $examsDatatables->addColumn('action', function($examData){
            return '';
        });
        return $examsDatatables->make(true);

    }

    public function candidateLogout(Request $request)
    {
        $this->checker($request);
        //delete the sessions and move the person to the login page
        $request->session()->forget('client_email');
        $request->session()->forget('client_name');

        $request->session()->flush();

        return redirect()->route('client.login.page');
    }

    public function adminViewResults(Request $request, $exam_id)
    {


        $datatables = CandidateTrait::candidatesExamResultsDT($exam_id);

        $exam = Exam::find($exam_id);
        $percent = $exam->pass_percengtage;

        //$datatables = Datatables::of($candidates);
        $datatables->editColumn('exam_id', function ($data){
            return $data->candidate->name;
        });
        $datatables->addColumn('email', function ($data){
            return $data->candidate->email;
        });
        $datatables->editColumn('results', function($data) use($percent){
            if ($data->results >= $percent) {
                return '<span class="label label-success">'.$data->results.'</span>';
            }else{
                return '<span class="label label-danger">'.$data->results.'</span>';
            }
            //return '50';
        });
        $datatables->editColumn('av_taken_test', function($data){
            if ($data->av_taken_test == 1) {
                //return 'Yes';
                return '<span class="label label-success">Yes</span>';
            }else{
                //return 'No';
                return '<span class="label label-default">No</span>';

            }
        });
        $datatables->editColumn('updated_at', function($data){
            return $data->updated_at;
        });

        return $datatables->make(true);
    }

    public function showViewResults(Request $request, $exam_id)
    {
        $exam = Exam::find($exam_id);
        return view('exam.view_results', ['exam' => $exam]);
    }
}
