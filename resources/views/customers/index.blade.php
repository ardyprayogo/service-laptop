@extends('layouts.app')
@section('title', 'Customer')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="table-responsive">
        <table class="table table-bordered" id="customers-table" width=100%>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Telp</th>
                    <th>Email</th>
                    <th>Address</th>
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
        $('#customers-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('customers-json')}}",
            columns: [
                {data: 'customer', name: 'customer'},
                {data: 'telp', name: 'telp'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true
        });
    })
    
</script>
@endsection