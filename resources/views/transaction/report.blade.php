@extends('layouts.app')
@section('title', 'Report')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="row my-5 align-items-end">
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_start">Tanggal Awal</label>
                <input type="date" id="filter_date_start" class="form-control datepicker">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="date_end">Tanggal Akhir</label>
                <input type="date" id="filter_date_end" class="form-control">
            </div>
        </div>
        <div class="col-md-4 text-center">
            <div class="form-group">
                <button class="btn btn-success btn-md btn-block" id="filter_button">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered" id="transaction-table" width=100%>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nomor Service</th>
                            <th>Customer</th>
                            <th>Laptop</th>
                            <th>Total Service</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        generateDataTable();
    });

    function generateDataTable(filter_date_start = '', filter_date_end = '') {
        var oTable = $('#transaction-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ url('transaction/json-report') }}",
                    data: {date_start:filter_date_start, date_end:filter_date_end}
                    },
                columns: [
                    {data: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'date_time', name: 'date_time', orderable: false},
                    {data: 'service_code', name: 'service_code', orderable: false},
                    {data: 'customer', name: 'customer', orderable: false},
                    {data: 'laptop', name: 'laptop', orderable: false},
                    {data: 'total_price', name: 'total_price', orderable: false}
                ],
                responsive: true
            });
    }

    $('#filter_button').click(function() {
        var date_start = $('#filter_date_start').val();
        var date_end = $('#filter_date_end').val();
        if (date_start != '' && date_end != '') {
            $('#transaction-table').DataTable().destroy();
            generateDataTable(date_start, date_end);
        }
    });
    
</script>
@endsection