@extends('layouts.app_client')

@section('content')

{{-- dump(Auth::user()) --}}

<!-- Portfolio Grid Section -->
    <section id="portfolio" style="margin-top: 100px;">
   <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color:#423562; color: #fff;">Exam Listing for {{ Auth::user()->name }}</div>

                <div class="panel-body table-responsive">
                    <table class="table" id="exam_list">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Exam Name</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection

@push('scripts')
<!-- Datatables -->
<script src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $('#exam_list').DataTable({
        serverSide: true,
        processing: true,
        ajax: '{!! route('candidate.exam.list.data') !!}',
        columnDefs:[
            {"className": "dt-center", "targets": "_all"}
        ],
        columns: [
            {data: 'rownum', name: 'rownum', orderable: false, searchable: false},
            {data: 'exam_id', name: 'exam_id'},
            {data: 'action', name: 'action'}
        ]
    });
</script>
@endpush
