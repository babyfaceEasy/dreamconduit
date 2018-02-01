@extends('layouts.app_client')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
        <!-- heading of the file -->
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>Exam Listing</h3>
        </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="fa fa-list" aria-hidden="true"></span>
                    Results
                </div>

                <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="exams">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam Name</th>
                                <th>Time</th>                       
                                <th>Taken Test ? </th>                       
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
@endsection

@push('scripts')
<script type="text/javascript">
    $('#exams').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{!! route('candidates.exam.list.data') !!}',
        columnDefs:[
            {"className": "dt-center", "targets": "_all"}
        ],
        columns: [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email', searchable: false},
            {data: 'results', name: 'results'},
            {data: 'av_taken_test', name: 'av_taken_test'} 
        ]
    });
</script>
@endsection