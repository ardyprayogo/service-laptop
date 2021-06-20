@extends('layouts.app')
@section('title', 'Service Types')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="text-right pb-5">
        <a href="{{ url('service-types/create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-fw fa-plus"></i>
            <span>Tambah</span> 
        </a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">x</button>	
			<strong>{{ session('success') }}</strong>
		</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="service-types-table" width=100%>
            <thead>
                <tr>
                    <th>Service Type</th>
                    <th>Keterangan</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#service-types-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('service-types/json')}}",
            columns: [
                {data: 'type', name: 'type'},
                {data: 'service_desc', name: 'service_desc'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true
        });
    })
    
</script>
@endsection