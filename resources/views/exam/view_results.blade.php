@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-offset-1">
        <!-- heading of the file -->
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>Result Listing</h3>
        </div>

        <a href="{{route('exam.index')}}" class="btn btn-warning" style="margin-bottom: 15px;"><span class="fa fa-arrow-left" aria-hidden="true"></span> Back to Exams</a> 
        <a href="{{route('specific.excel.results', ['exam_id' => Request::segment(4)])}}" class="btn btn-default" style="margin-bottom: 15px;"><span class="fa fa-file-excel-o" aria-hidden="true"></span> Export all Results</a>

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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Percentage</th>                       
                                <th>Taken Test ? </th>
                                <th>Time Taken</th>                      
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
        dom: 'Bfrip',
        buttons: [
            {
                extend: 'excel',
                title: '{!! $exam->exam_name !!} + results',
            }
        ],
        serverSide: true,
        processing: true,
        ajax: '{!! route('admin.results.data', ['exam_id' => Request::segment(4)]) !!}',
        columnDefs:[
            {"className": "dt-center", "targets": "_all"}
        ],
        columns: [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'exam_id', name: 'exam_id'},
            {data: 'email', name: 'email', searchable: false},
            {data: 'results', name: 'results'},
            {data: 'av_taken_test', name: 'av_taken_test'},
            {data: 'updated_at', name: 'updated_at'}
        ]
    });
</script>
@endpush
