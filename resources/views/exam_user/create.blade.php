@extends('layouts.app')

@section('content')

    <!--<button id="btn_exmple" class="btn btn-primary">Click Me</button>-->
    <!-- form for deleting all candidates -->
    <form method="POST" style="display: none;" id="clear-candidates-form" action="{{ route('exam.clear.candidates') }}">
        {{csrf_field()}}
        {{-- method_field('DELETE') --}}
        <input type="hidden" name="exam_id" value="{{$exam_id}}">
    </form>
    <!-- end of the form -->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>Manage Candidates</h3>
        </div>
            @include('includes.flash')
            <div class="panel panel-default">
                <div class="panel-heading"> <span class="fa fa-cog" aria-hidden="true"></span> Manage Candidates</div>

                <?php //dump($exam_id); ?>
                <div class="panel-body">
                    <a href="{{route('exam.index')}}" class="btn btn-warning"><span class="fa fa-arrow-left" aria-hidden="true"></span> Back to Exams</a>
                    <a href="#" id="add_cand_btn" class="btn btn-primary"><span class="fa fa-plus" aria-hidden="true"></span> Add Candidates</a>
                    <a href="#" data-toggle="modal" data-target="#myModal" class="btn btn-danger"><span class="fa fa-minus" aria-hidden="true"></span> Clear Candidates</a>
                    <div id="add_cand" style="display: none; padding-top: 10px;">
                    <form id="" method="post" action="{{route('candidates.store')}}" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <input type="hidden" name="type" value="single">
                      <input type="hidden" name="exam_id" value="{{$exam_id}}">
                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="name" class="form-control" name="name" id="name">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-default">Add Candidate</button>
                    </form>
                    <hr>
                    <form id="" method="post" action="{{route('candidates.store')}}" role="form" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <input type="hidden" name="exam_id" value="{{$exam_id}}">
                      <input type="hidden" name="type" value="group">
                      <div class="form-group{{ $errors->has('names_excel') ? ' has-error' : '' }}">
                        <label for="question">Candidates</label>
                        <input type="file" name="names_excel" id="names_excel">
                        @if ($errors->has('names_excel'))
                            <span class="help-block">
                                <strong>{{ $errors->first('names_excel') }}</strong>
                            </span>
                        @endif
                      </div>

                      <!-- dis is to download a sample of the uploadable list -->
                      <a href="{{ route('batch.upload.sample') }}">Click here to download sample file</a> <br>

                      <button type="submit" class="btn btn-default">Upload Candidates</button>
                    </form>
                    </div><!-- End of the id:add_cand -->
                </div>
            </div>

            <div class="panel panel-info">
                <div class="panel-heading">
                    <span class="fa fa-list" aria-hidden="true"></span>
                    Added Candidates
                </div>
                <div class="panel-body">
                    <div class="responsive">
                        <table class="table" id="specific_candidates">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Key</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Clear Candidates !</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to clear the list of candidates for this exam?<br>
                        <span class="text-danger">NB: It will delete the results of the candidates too.</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button"
                            onclick="document.getElementById('clear-candidates-form').submit()"
                            class="btn btn-success">Clear Candidates</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- this is for the delete candidate effect -->
    <div class="modal fade" id="del_candidate_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Delete Candidate !</h5>
                </div>
                <div class="modal-body">
                    <span id="val_id" style="display: none"></span>
                    <p>Are you sure you want to delete this candidate?<br>
                        <span class="text-danger">NB: It will delete the results of the candidate too.</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button"
                            onclick="performDeleteCandidate($('.modal-body  #val_id').text())"
                            class="btn btn-success">Delete Candidate</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- this is for the delete candidate effect -->
    <div class="modal fade" id="res_candidate_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h5 class="modal-title">Reset Candidate !</h5>
                </div>
                <div class="modal-body">
                    <span id="res_url" style="display: none"></span>
                    <p>Are you sure you want to reset this candidate?<br>
                        <span class="text-danger">NB: It will turn the candidate's score to 0.</span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button"
                            onclick="performResetCandidate($('.modal-body  #res_url').text())"
                            class="btn btn-success">Reset Candidate</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@push('scripts')

<script type="text/javascript">

    $.ajaxSetup({
        beforeSend: function( xhr ) {
            xhr.setRequestHeader(
                'X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content')
            );
        }
    });

    function resetCandidate(elt, id) {
        var url = elt.dataset.url;
        //$(this).url
        $(".modal-body  #res_url").text( url );
        $('#res_candidate_modal').modal('show');
    }

    function performResetCandidate( url ) {

        var exam_id = '{{ Request::segment(3) }}';

        $.post(
            url,
            {'exam_id': exam_id},
            function (msg) {
                //console.log("It worked");
                $('#res_candidate_modal').modal('hide');
                alert(msg['success']);
                setInterval(function() { window.location.reload(); }, 900);
            }
        ).fail(function (data) {
            if( data.status == 422){
                $('#res_candidate_modal').modal('hide');
                alert('An error occurred, please try again later.');
            }
        });
    }//end of performResetCandidate()

    function deleteCandidate(elt, id) {
        //alert(id);
        var url = elt.dataset.url;
        //$(this).url
        $(".modal-body  #val_id").text( url );
        $('#del_candidate_modal').modal('show');
    }

    function performDeleteCandidate( url ) {

        var exam_id = '{{ Request::segment(3) }}';

        $.ajax({
            url: url,
            type: 'DELETE',
            data: {'exam_id': exam_id},
            dataType: "JSON",
            beforeSend: function( xhr ){
                xhr.setRequestHeader(
                    'X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content')
                );
            },
            success: function (msg) {
                //console.log("It worked");
                $('#del_candidate_modal').modal('hide');
                alert(msg['success']);
                setInterval(function() { window.location.reload(); }, 900);
            },
            error: function (data) {
                if( data.status == 422){
                    $('#del_candidate_modal').modal('hide');
                    alert('An error occurred, please try again later.');
                }
            }
        });
    }
    $(function(){
        $('#del_btn').click(function () {
            alert('kay');
        });
        $('#add_cand_btn').click(function(){
            $('#add_cand').toggle();
        });

        $('#far_away').click(function () {
            alert('kay');
        });

        $('#specific_candidates').DataTable({
            dom: 'Bfrip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Candidates'
                }
            ],
            serverSide: true,
            processing: true,
            ajax: '{!! route('admin.specific.cand', ['id' => $exam_id])!!}',
            columns: [
                {data: 'examuser_id', name: 'examuser_id'},
                {data: 'email', name: 'email', searchable: false} ,
                {data: 'key', name: 'key', searchable: false} ,
                {data: 'action', name: 'action', searchable: false}
            ]
        });
    });
</script>
@endpush
