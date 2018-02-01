@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Candidates</div>

                <div id="exam_id_cont">1</div>
                <div class="panel-body">
                    <table class="table" id="candidates">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>                                          
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
    $('#candidates').DataTable({
        serverSide: true,
        processing: true,
        ajax: {
            url: '{!! route('candidates.specific.data') !!}',
            data: function (d){
                d.exam_id = $('#exam_id_cont').val();
            }
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email', searchable: false}  
        ]
    });
</script>
@endpush
