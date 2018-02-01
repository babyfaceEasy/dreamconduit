@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>New Examination Info.</h3>
        </div>
            <div class="panel panel-default">
                <div class="panel-heading"> <span class="fa fa-pencil-square" aria-hidden="true"></span> New Examination Info.</div>

                <div class="panel-body">
                    <form method="post" action="{{route('exam.store')}}" role="form">
                        {{csrf_field()}}
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                      <div class="form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
                        <label for="exam_name">Examination Name</label>
                        <input type="text" value="{{ old('exam_name') }}" name="exam_name" class="form-control" id="exam_name" placeholder="">
                        @if ($errors->has('exam_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('exam_name') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="form-group{{ $errors->has('no_of_quest') ? ' has-error' : '' }}">
                        <label for="no_of_quest">No. of Questions</label>
                        <input type="number" value="{{ old('no_of_quest') }}" name="no_of_quest" class="form-control" id="no_of_quest">
                        @if ($errors->has('no_of_quest'))
                            <span class="help-block">
                                <strong>{{ $errors->first('no_of_quest') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="form-group{{ $errors->has('pass_percengtage') ? ' has-error' : '' }}">
                        <label for="pass_percengtage">Pass Percentage</label>
                        <div class="input-group">
                            <input type="number" value="{{ old('pass_percengtage') }}" name="pass_percengtage" class="form-control" id="pass_percengtage">
                            <span class="input-group-addon">%</span>
                        </div>
                        
                        <span id="helpBlock" class="help-block">This is the minimum pass percentage, it can't be more than 100%.</span>
                        @if ($errors->has('pass_percengtage'))
                            <span class="help-block">
                                <strong>{{ $errors->first('pass_percengtage') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('time') ? ' has-error' : '' }}">
                        <label for="timer">Timer</label>
                        <div class="input-group">
                            <input type="number" value="{{ old('time') }}" name="time" class="form-control" id="time" placeholder="">
                            <span class="input-group-addon">Minutes</span>
                        </div>
                        
                        <span id="helpBlock" class="help-block">The time must be in minutes.</span>
                        @if ($errors->has('time'))
                            <span class="help-block">
                                <strong>{{ $errors->first('time') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date">Start Date</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('start_date') }}" name="start_date" class="form-control" id="start_date" placeholder="">
                            <span class="input-group-addon">YYYY-mm-dd</span>
                        </div>
                        <span id="helpBlock" class="help-block">The date should be today or forward.</span>

                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('finish_date') ? ' has-error' : '' }}">
                        <label for="finish_date">Finish Date</label>
                        <div class="input-group">
                            <input type="text" value="{{ old('finish_date') }}" name="finish_date" class="form-control" id="finish_date">
                            <span class="input-group-addon">YYYY-mm-dd</span>
                        </div>
                        
                        <span id="helpBlock" class="help-block">The date should be after Start Date.</span>
                        @if ($errors->has('finish_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('finish_date') }}</strong>
                            </span>
                        @endif
                      </div>
                        <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                            <label for="question">Instruction</label>
                            <textarea class="form-control" name="instruction" id="instruction">{{old('instruction')}}</textarea>
                            @if ($errors->has('instruction'))
                                <span class="help-block">
                                <strong>{{ $errors->first('instruction') }}</strong>
                            </span>
                            @endif
                        </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{URL::asset('cs/jquery.countdown.min.js')}}"></script>
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    $(function(){
        tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: ['table spellchecker contextmenu paste textcolor lists']
        });
    });
</script>
@endpush
