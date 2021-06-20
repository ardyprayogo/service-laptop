@extends('layouts.app')
@section('title', 'Services')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="text-right pb-5">
        <a href="{{ url('services/create') }}" class="btn btn-success btn-sm">
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
        <table class="table table-bordered" id="services-table" width=100%>
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Type</th>
                    <th>Harga</th>
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
        $('#services-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('services/json')}}",
            columns: [
                {data: 'service', name: 'service'},
                {data: 'type', name: 'type'},
                {data: 'price', name: 'price'},
                {data: 'desc', name: 'desc'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true
        });
    })
    
</script>
@endsection