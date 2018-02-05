@extends('layouts.app')

@section('content')

  <div class="container">
      <div class="row">
          <div class="col-md-8 col-md-offset-2">
          <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
              <h3>Export Results</h3>
          </div>
              @include('includes.flash')
              <div class="panel panel-default">
                  <div class="panel-heading"> <span class="fa fa-cog" aria-hidden="true"></span> Manage Candidates</div>

                  <?php //dump($exam_id); ?>
                  <div class="panel-body">
                      <a href="{{route('exam.index')}}" class="btn btn-warning"><span class="fa fa-arrow-left" aria-hidden="true"></span> Back to Exams</a>
                      <div id="add_cand" style="display: none; padding-top: 10px;">
                      <form id="" method="post" action="{{route('candidates.store')}}" role="form" enctype="multipart/form-data">
                          {{csrf_field()}}
                        <input type="hidden" name="type" value="single">
                        <input type="hidden" name="exam_id" value="{{$exam_id}}">

                        <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                          <label for="start_date">Start date</label>
                          <input type="text" class="form-control" name="start_date" id="start_date">
                          @if ($errors->has('start_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('start_date') }}</strong>
                              </span>
                          @endif
                        </div>

                        <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                          <label for="end_date">Start date</label>
                          <input type="text" class="form-control" name="end_date" id="end_date">
                          @if ($errors->has('end_date'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('end_date') }}</strong>
                              </span>
                          @endif
                        </div>

                        <button type="submit" class="btn btn-default">Download Results</button>
                      </form>
                      </div><!-- End of the id:add_cand -->
                  </div>
              </div>

          </div>
      </div>
  </div>

  @endsection
