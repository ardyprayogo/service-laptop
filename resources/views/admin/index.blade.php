@extends('layouts.app')
@section('title', 'Admin')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="table-responsive">
        <table class="table table-bordered" id="users-table" width=100%>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#users-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('user-json')}}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            responsive: true
        });
    })
    
</script>
@endsection