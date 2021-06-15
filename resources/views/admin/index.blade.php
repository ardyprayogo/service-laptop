@extends('layouts.app')
@section('title', 'Admin')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="align-items-right pb-5">
        <a href="{{ url('user/create') }}" class="btn btn-success btn-sm">Create</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-block">
			<button type="button" class="close" data-dismiss="alert">x</button>	
			<strong>{{ session('success') }}</strong>
		</div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered" id="users-table" width=100%>
            <thead>
                <tr>
                    <th>Name</th>
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
        $('#users-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('user/json') }}",
            columns: [
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