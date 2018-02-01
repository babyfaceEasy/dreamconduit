@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
        <div style="border-bottom: 2px solid #000; margin-bottom: 20px;">
            <h3>Examination Listings</h3>
        </div>
        @include('includes.flash')
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-cog" aria-hidden="true"></span> Exam Listing</div>

                <div class="panel-body">
                    <table class="table" id="exams">
                        <thead>
                            <tr>
                                <th style="text-align: center;">#</th>
                                <th style="text-align: center;">name</th>
                                <th style="text-align: center;"># of Quest.</th>
                                <th style="text-align: center;">Start</th>                       
                                <th style="text-align: center;">Finish</th>                       
                                <th style="text-align: center;">Action</th>                       
                            </tr>
                        </thead>
                    </table>
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
        ajax: '{!! route('exam.data') !!}',
        columnDefs:[
            {"className": "dt-center", "targets": "_all"}
        ],
        columns: [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'exam_name', name: 'exam_name'},
            {data: 'no_of_quest', name: 'no_of_quest', searchable: false},
            {data: 'start_date', name: 'start_date'},
            {data: 'finish_date', name: 'finish_date'},
            {data: 'action', name: 'action', orderable: false, searchable: false}  
        ]
    });
</script>
@endpush
