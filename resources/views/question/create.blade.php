@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>Manage Questions</h3>
        </div>
            @include('includes.flash')
            <div class="alert alert-info" role="alert">
                <strong>NB: </strong> You have {{$avail_quests}} out of {{$total_quest}} question(s) in the bank already. <br>You can't add more than {{$total_quest}} questions.
            </div>
            <div class="panel panel-default">
                <div class="panel-heading"> <span class="fa fa-cog" aria-hidden="true"></span> Manage Questions</div>

                <?php //dump($exam_id); ?>
                <div class="panel-body">
                    <a href="{{route('exam.index')}}" class="btn btn-warning"><span class="fa fa-arrow-left" aria-hidden="true"></span> Back to Exams</a> 
                    <a href="#" id="add_quest_btn" class="btn btn-primary"><span class="fa fa-plus" aria-hidden="true"></span> Add Question</a>
                    <div id="add_quest" style="display: none;">
                    <form method="post" action="{{route('quest.store')}}" role="form">
                        {{csrf_field()}}
                      <input type="hidden" name="exam_id" value="{{$exam_id}}">
                      <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                        <label for="question">Question</label>
                        <textarea class="form-control" name="question" id="question">{{old('question')}}</textarea>
                        <!--<input type="text" value="{{ old('exam_name') }}" name="exam_name" class="form-control" id="exam_name" placeholder="Exam Name">-->
                        @if ($errors->has('question'))
                            <span class="help-block">
                                <strong>{{ $errors->first('question') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('option_a') ? ' has-error' : '' }}">
                        <label for="option_a">Option A</label>
                        <input type="text" value="{{ old('option_a') }}" name="option_a" class="form-control" id="option_a" placeholder="Option A">
                        @if ($errors->has('option_a'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option_a') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('option_b') ? ' has-error' : '' }}">
                        <label for="option_b">Option B</label>
                        <input type="text" value="{{ old('option_b') }}" name="option_b" class="form-control" id="option_b" placeholder="Option B">
                        @if ($errors->has('option_b'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option_b') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('option_c') ? ' has-error' : '' }}">
                        <label for="option_c">Option C</label>
                        <input type="text" value="{{ old('option_c') }}" name="option_c" class="form-control" id="option_c" placeholder="Option C">
                        @if ($errors->has('option_c'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option_c') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('option_d') ? ' has-error' : '' }}">
                        <label for="option_d">Option D</label>
                        <input type="text" value="{{ old('option_d') }}" name="option_d" class="form-control" id="option_d" placeholder="Option D">
                        @if ($errors->has('option_d'))
                            <span class="help-block">
                                <strong>{{ $errors->first('option_d') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="form-group{{ $errors->has('correct_ans') ? ' has-error' : '' }}">
                        <label for="correct_ans">Correct  Ans</label>
                          <!--<input type="text" value="{{-- $question->correct_ans --}}" name="correct_ans" class="form-control" id="correct_ans" placeholder="Correct  Answer">-->
                          <select name="correct_ans" class="form-control" id="correct_ans">
                              <option value="">:: Select Answer Option ::</option>
                              <option value="a">Option A</option>
                              <option value="b">Option B</option>
                              <option value="c">Option C</option>
                              <option value="d">Option D</option>
                          </select>
                        @if ($errors->has('correct_ans'))
                            <span class="help-block">
                                <strong>{{ $errors->first('correct_ans') }}</strong>
                            </span>
                        @endif
                      </div>
                      
                      <button type="submit" class="btn btn-default">Add Question</button>
                    </form>
                    </div><!-- End of id:add_quest -->
                </div>
            </div> <!-- end of default panel -->

            <div class="panel panel-info">
                <div class="panel-heading">
                    <span class="fa fa-pencil-square" aria-hidden="true"></span>
                    Questions Added
                </div>

                <div class="panel-body">
                    <?php $counter = 1; ?>
                    @foreach($quests as $question)
                        <div class="panel panel-default">
                            <div class="panel-heading" id="{{$counter}}">
                                <a href="#{{$counter}}">Question #{{$counter}}</a>
                            </div>
                            <div class="panel-body" style="display: none;">
                            <!--form start -->
                                <form method="post" action="{{route('quest.update', ['id' => $question->id])}}" role="form">
                                    {{csrf_field()}} {{ method_field('PUT') }}
                                  <input type="hidden" name="exam_id" value="{{$exam_id}}">
                                  <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                                    <label for="question">Question</label>
                                    <textarea class="form-control" name="question" id="question">{{$question->question}}</textarea>
                                    <!--<input type="text" value="{{ old('exam_name') }}" name="exam_name" class="form-control" id="exam_name" placeholder="Exam Name">-->
                                    @if ($errors->has('question'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('question') }}</strong>
                                        </span>
                                    @endif
                                  </div>

                                  <div id="{{$counter}}" class="form-group{{ $errors->has('option_a') ? ' has-error' : '' }}">
                                    <label for="option_a">Option A</label>
                                    <input type="text" value="{{ $question->option_a }}" name="option_a" class="form-control" id="option_a" placeholder="Option A">
                                    @if ($errors->has('option_a'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('option_a') }}</strong>
                                        </span>
                                    @endif
                                  </div>

                                  <div class="form-group{{ $errors->has('option_b') ? ' has-error' : '' }}">
                                    <label for="option_b">Option B</label>
                                    <input type="text" value="{{ $question->option_b }}" name="option_b" class="form-control" id="option_b" placeholder="Option B">
                                    @if ($errors->has('option_b'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('option_b') }}</strong>
                                        </span>
                                    @endif
                                  </div>

                                  <div class="form-group{{ $errors->has('option_c') ? ' has-error' : '' }}">
                                    <label for="option_c">Option C</label>
                                    <input type="text" value="{{ $question->option_c }}" name="option_c" class="form-control" id="option_c" placeholder="Option C">
                                    @if ($errors->has('option_c'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('option_c') }}</strong>
                                        </span>
                                    @endif
                                  </div>

                                  <div class="form-group{{ $errors->has('option_d') ? ' has-error' : '' }}">
                                    <label for="option_d">Option D</label>
                                    <input type="text" value="{{ $question->option_d }}" name="option_d" class="form-control" id="option_d" placeholder="Option D">
                                    @if ($errors->has('option_d'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('option_d') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  <div class="form-group{{ $errors->has('correct_ans') ? ' has-error' : '' }}">
                                    <label for="correct_ans">Correct  Ans</label>
                                    <!--<input type="text" value="{{-- $question->correct_ans --}}" name="correct_ans" class="form-control" id="correct_ans" placeholder="Correct  Answer">-->
                                    <select name="correct_ans" class="form-control" id="correct_ans">
                                        <option value="">:: Select Answer Option ::</option>
                                        <option value="a" @if($question->correct_ans == 'a') selected @endif>Option A</option>
                                        <option value="b" @if($question->correct_ans == 'b') selected @endif>Option B</option>
                                        <option value="c" @if($question->correct_ans == 'c') selected @endif>Option C</option>
                                        <option value="d" @if($question->correct_ans == 'd') selected @endif>Option D</option>
                                    </select>
                                    @if ($errors->has('correct_ans'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('correct_ans') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                  
                                  <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-pencil-square"></span>
                                    Update
                                  </button>
                                  <button type="submit" class="btn btn-danger" onclick="event.preventDefault(); $('#delete_form_'+{{$counter}}).submit()">
                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                    Delete
                                  </button>
                                </form>
                                <form id="delete_form_{{$counter}}" method="post" action="{{route('quest.destroy', ['id' => $question->id])}}">
                                    {{ method_field('DELETE') }} {{csrf_field()}}
                                </form>
                            </div>
                        </div>
                        <?php $counter++; ?>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    $.fn.scrollView = function () {
        return this.each(function () {
            $('html, body').animate({
                scrollTop: $(this).offset().top
            }, 1000);
        });
    }
    $(function(){

        //$('#3').scrollView();

        $('#add_quest_btn').click(function(){
            $('#add_quest').toggle('slide');
        });

        $('.panel-heading').click(function() {
            //var clicked = $(this).attr('id');
            //console.log(clicked);
            $(this).siblings('.panel-body').toggle('fade');
            $('#'+$(this).attr('id')).scrollView();
        });

        tinymce.init({
            selector: 'textarea',
            theme: 'modern',
            plugins: ['table spellchecker contextmenu paste textcolor lists']
        });
    });
</script>
@endpush
