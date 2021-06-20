@extends('layouts.app')
@section('title', 'Transaction')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="text-right pb-5">
        <a href="{{ url('transaction/create') }}" class="btn btn-success btn-sm">
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
        <table class="table table-bordered" id="transaction-table" width=100%>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nomor Service</th>
                    <th>Status</th>
                    <th>Customer</th>
                    <th>Telp</th>
                    <th>Laptop</th>
                    <th>Keluhan</th>
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
        $('#transaction-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('transaction/json')}}",
            columns: [
                {data: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'date_time', name: 'date_time'},
                {data: 'service_code', name: 'service_code'},
                {data: 'status', name: 'status'},
                {data: 'customer', name: 'customer'},
                {data: 'telp', name: 'telp'},
                {data: 'laptop', name: 'laptop'},
                {data: 'case', name: 'case'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true
        });
    })
    
</script>
@endsection