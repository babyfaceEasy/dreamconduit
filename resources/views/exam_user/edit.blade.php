<!-- this page uploads the file of emails and names -->
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
                    <h3>Edit Candidate</h3>
                </div>
                @include('includes.flash')
                <div class="panel panel-default">
                    <div class="panel-heading"> <span class="fa fa-cog" aria-hidden="true"></span> Edit Candidates</div>

                    <?php //dump($exam_id); ?>
                    <div class="panel-body">
                        <a href="{{route('exam.index')}}" class="btn btn-warning"><span class="fa fa-arrow-left" aria-hidden="true"></span> Back to Exams</a>
                        <div id="add_cand" style="padding-top: 10px;">
                            <form id="" method="post" action="{{route('candidates.update', ['id' => $candidate->id])}}" role="form">
                                {{csrf_field()}}
                                {{method_field('PUT')}}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{$candidate->email}}">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input type="name" class="form-control" name="name" id="name" value="{{$candidate->name}}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-default">Update Candidate</button>
                            </form>
                        </div><!-- End of the id:add_cand -->
                    </div>
                </div>



            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script type="text/javascript">

    </script>
    @endpush
