<?php

//firtbank
//3076386755

//http://stackoverflow.com/questions/39394206/laravel-5-2-drop-foreign-key
//https://stackoverflow.com/jobs/136289/php-developer-100-remote-time-doctor?offset=1&r=True
namespace App\Http\Controllers;

use App\Pivot;
use App\Traits\CandidateTrait;
use Illuminate\Http\Request;
use Datatables;
use App\Exam;
use App\ExamUser;
use App\Candidate;
use Log;
use DB;
use Session;
use Excel;
use App\Traits\ExamTrait;

class ExamController extends Controller
{
    //traits section
    use ExamTrait;


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['candidateLogin']]);
    }

    //this returns the data for the exams table
    public function getExamData(Request $request)
    {
        DB::statement(DB::raw('set @rownum:=0'));
        $exams =  Exam::select([
            DB::raw('@rownum := @rownum + 1 AS rownum'),
            'id',
            'exam_name',
            'start_date',
            'finish_date',
            'no_of_quest'
        ]);

        $datatables = $this->examDataDT();

        if($keyword = $request->get('search')['value']){
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum + 1 like ?', ["%{keyword}%"]);
        }

        //<a href="'.route('candidates.index', ['exam_id' => $exam->id]). '" class="btn btn-sm btn-success">View Candidates</a>
        //<i class="fa fa-cog" aria-hidden="true"></i>
        //this is to add the action column
        $datatables->addColumn('action', function($exam){
            $quest_route  = route('quest.index', ['exam_id'=>$exam->id]);
            //$quest_route  = route('quest.index', ['exam_id'=>$exam->id]);
            return '<a href="'.route('quest.index', ['exam_id' => $exam->id]).'" class="fa fa-cog btn btn-sm btn-info"> Manage Questions</a>
              <a href="'.route('candidates.index', ['exam_id' => $exam->id]). '" class="fa fa-cog btn btn-sm btn-warning"> Manage Candidates</a>
              <a href="'.route('admin.results', ['exam_id' => $exam->id]). '" class="fa fa-eye-slash btn btn-sm btn-success"> View Results</a>
              <a href="'.route('exam.edit', ['id' => $exam->id]). '" class="fa fa-pencil-square-o btn btn-sm btn-default" title="Edit Exam"></a>';
        });

        //this is to set the dates to Y-m-d
        $datatables->editColumn('start_date', function($exam){
            $date = new \DateTime($exam->start_date);
            //dump();
            return date_format($date, 'Y-m-d');
        });
        //this is to set the dates to Y-m-d
        $datatables->editColumn('finish_date', function($exam){
            $date = new \DateTime($exam->finish_date);
            return date_format($date, 'Y-m-d');
        });
        return $datatables->make(true);
    }

    //this return the page where u set the duration to exportAllResults
    public function durationPage(Request $request, $id)
    {
      return view('exam.export_results')->with('exam_id', $id);
    }

    public function postExportResults(Request $request)
    {
      //dd($request->all());
      $this->validate($request, [
        'start_date' => '',
        'end_date' => ''
      ]);

      //DB::enableQueryLog();

      $data = Pivot::where('exam_id', $request->input('exam_id'));
      if ( $request->input('start_date') != '' && $request->input('end_date') != '' ){
        $data = $data->whereBetween('created_at', [$request->input('end_date'), $request->input('start_date')])->get();
        //echo 'kunle';
      }else{
      	$data = $data->get();
      }

      //dump($data);
      //dd(DB::getQueryLog());
      //die();


      //dd($data);

      /*if($request->input('start_date') != ''){
        $data = $data->whereDate('created_at', $request->input('start_date'));
      }*/



      //dd($data);
      //dd($data->get());
      //$data = $data->get();
      //dd($data);


      if ($data->count() == 0) {
        return redirect()->route('duration.excel.results', ['exam_id', $request->input('exam_id')])
          ->with('err_msg', 'Results were not found for the specified duration.');
      }

      //dd($data);
      $exam_name = $data->get(0)->exam->exam_name;

      //dd($data->get(0)->exam->exam_name);


      if($exam_name != null){

        Excel::create($exam_name, function ($excel) use($data){
            $excel->sheet('results', function ($sheet) use($data){
                $data = $data->each(function($item, $key) {
                    //dd($key);

                    $item->exam_id = $item->exam->exam_name;
                    $item->examuser_id = $item->candidate->name;
                    if ($item->av_taken_test == 0){
                        $item->av_taken_test = 'No';
                    }else{
                        $item->av_taken_test = 'Yes';
                    }

                    if ($item->results == 0){
                        $item->results = '0';
                    }
                    $item->updated_at = $item->updated_at;

                });
                $data = $data->toArray();
                foreach($data as $key => $dt){
                  unset($dt['exam']);
                  unset($dt['candidate']);
                  $data[$key] = $dt;
                  //dd($dt);
                  //unset($dt['exam']);
                  //unset($dt['candidate']);
                }
                //die();
                //dd($data);
                $sheet->fromArray($data);
                /*$sheet->fromArray(array(
                  array('data1', 'data2'),
          array('data3', 'data4')
                ));*/
            });

        })->download('xls');

      }//end of if()
    }

    public function exportAllResults($id)
    {
        $data = Pivot::where('exam_id', $id)->get();

        //dd($data);
        $exam_name = $data->get(0)->exam->exam_name;

        //dd($data->get(0)->exam->exam_name);


        if($exam_name != null){

        	Excel::create($exam_name, function ($excel) use($data){
	            $excel->sheet('results', function ($sheet) use($data){
	                $data = $data->each(function($item, $key) {
	                    //dd($key);

	                    $item->exam_id = $item->exam->exam_name;
	                    $item->examuser_id = $item->candidate->name;
	                    if ($item->av_taken_test == 0){
	                        $item->av_taken_test = 'No';
	                    }else{
	                        $item->av_taken_test = 'Yes';
	                    }

	                    if ($item->results == 0){
	                        $item->results = '0';
	                    }
	                    $item->updated_at = $item->updated_at;

	                });
	                $data = $data->toArray();
	                foreach($data as $key => $dt){
	                	unset($dt['exam']);
	                	unset($dt['candidate']);
	                	$data[$key] = $dt;
	                	//dd($dt);
	                	//unset($dt['exam']);
	                	//unset($dt['candidate']);
	                }
	                //die();
	                //dd($data);
	                $sheet->fromArray($data);
	                /*$sheet->fromArray(array(
	                	array('data1', 'data2'),
    				array('data3', 'data4')
	                ));*/
	            });

	        })->download('xls');

        }//end of if()

    }//end of exportAllResults()


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd('kunle');
        $this->validate($request, [
            'exam_name' => 'required|max:200|string',
            'no_of_quest' => 'required|integer|max:50|digits_between:1,2',
            'pass_percengtage' => 'required|integer|max:100|digits_between:1,3',
            'start_date' => 'required|date_format:Y-m-d|after:yesterday',
            'finish_date' => 'required|date_format:Y-m-d|after:start_date',
            'user_id' => 'required|numeric',
            'time' => 'required|numeric',
            'instruction' => 'required'
        ]);

        $input = $request->only('exam_name', 'no_of_quest', 'pass_percengtage', 'start_date', 'finish_date', 'user_id', 'time', 'instruction');

        $ret = Exam::create($input);

        if(is_null($ret))
        {
            //show error message
            Session::flash('err_msg', 'An error occurred, please try again later.');
            return redirect()->back();
            //TODO: log this data
        }
        else
        {
            //show success and redirect
            Session::flash('suc_msg', 'Examination Info. creation was successful.');
            return redirect()->route('exam.index');
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
        $exam = Exam::find($id);
        return view('exam.edit', compact('exam'));
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
        $this->validate($request, [
            'exam_name' => 'required|max:200|string',
            'no_of_quest' => 'required|integer|max:50|digits_between:1,2',
            'pass_percengtage' => 'required|integer|max:100|digits_between:1,3',
            'start_date' => 'required|date_format:Y-m-d H:i:s',
            'finish_date' => 'required|date_format:Y-m-d H:i:s|after:start_date',
            //'user_id' => 'required|numeric',
            'time' => 'required|numeric',
            'instruction' => 'required'
        ]);

        //dd($request);
        //after validation
        $input = $request->only('exam_name', 'no_of_quest', 'pass_percengtage', 'start_date', 'finish_date', 'time', 'instruction');

        $exam_thing = Exam::find($id);
        $ret = $exam_thing->update($input);

        if(is_null($ret))
        {
            Session::flash('err_msg', 'An error occurred, please try again later.');
            return redirect()->back();
        }
        else
        {
            Session::flash('suc_msg', 'Update  was successful');
            return redirect()->route('exam.edit', ['id' => $exam_thing->id]);
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
        //
    }

    public function specificCandidatesData(Request $request, $id)
    {
        $datatables = CandidateTrait::specificCandidatesDT($id);
        /*$datatables->editColumn('examuser_id', function ($candidate){
            return $candidate->candidate->name;
        });
        $datatables->addColumn('email', function ($candidate){
            return $candidate->candidate->email;
        });
        $datatables->addColumn('key', function ($candidate){
            return $candidate->candidate->unique_key;
        });*/
        $datatables->addColumn('action', function ($candidate){
            return '<a href="'.route('candidates.edit', ['id' => $candidate->examuser_id]). '" title="Edit Candidate" class="fa fa-pencil-square-o btn btn-sm btn-warning"> </a>
              <a title="Delete Candidate" title="Delete Candidate" data-url = "'.route('admin.delete.client', $candidate->examuser_id).'" onclick="deleteCandidate(this,'.$candidate->examuser_id.' )" class="icon fa fa-trash-o btn btn-sm btn-danger"></a>
              <a title="Reset Candidate" title="Reset Candidate" data-url = "'.route('admin.reset.client', $candidate->examuser_id).'" onclick="resetCandidate(this,'.$candidate->examuser_id.' )" class="icon fa fa-refresh btn btn-sm btn-info"></a>

            ';
        });
        /*$datatables->filter(function ($query){
          if (request()->has('email')) {
            # code...
          }
        });*/
        return $datatables->make(true);
    }



}
