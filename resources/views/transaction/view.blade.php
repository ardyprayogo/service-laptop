@extends('layouts.app')
@section('title', 'View Transaction')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    <div class="row">
        <div class="col-md-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary btn-circle btn-lg" href="{{ url('transaction/print').'/'.$id }}" target="__BLANK">
                    <i class="fas fa-print"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Invoice</h1>
            <h4>{{ $header->service_code }}</h4>
            <hr class="sidebar-divider my-5">
        </div>
        <div class="col-md-4">
            Tanggal Service
        </div>
        <div class="col-md-8">
            {{ $header->date_time }}
        </div>
        <div class="col-md-4">
            Kasir
        </div>
        <div class="col-md-8">
            {{ $header->name }}
        </div>
        <div class="col-md-4">
            Pelanggan
        </div>
        <div class="col-md-8">
            {{ $header->customer }}
        </div>
        <div class="col-md-4">
            Alamat
        </div>
        <div class="col-md-8">
            {{ $header->address }}
        </div>
        <div class="col-md-4">
            Laptop
        </div>
        <div class="col-md-8">
            {{ $header->laptop }}
        </div>
        <div class="col-md-4">
            Keluhan
        </div>
        <div class="col-md-8">
            {{ $header->case }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h5 class="my-3">
                Service Detail :
            </h5>
            <div class="table-responsive">
                <table class="table table-bordered" id="customers-table" width=100%>
                    <thead class="text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Service</th>
                            <th>Tipe</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($details as $detail)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $detail->service }}</td>
                                <td>{{ $detail->type }}</td>
                                <td class="text-right">{{ $detail->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-8 text-right">
            <h4>Total Biaya Service</h4>
        </div>
        <div class="col-md-4 text-right">
            <h4>{{ $header->total_price }}</h4>
        </div>

        @if ($header->service_status == '00')
            <div class="col-md-8 text-right">
                <h4>DP</h4>
            </div>
            <div class="col-md-4 text-right">
                <h4>{{ $header->down_payment }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <h2>Sisa Bayar</h2>
            </div>
            <div class="col-md-4 text-right">
                <h2>{{ $header->total_price - $header->down_payment }}</h2>
            </div>
        @endif
    </div>

    @if ($header->service_status == '00')
        <hr class="sidebar-divider my-5">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="form-group">
                    <h4 class="text-success">Selesai</h4>
                    <a class="btn btn-success btn-circle btn-lg" href="{{ url('transaction/finish').'/'.$id }}">
                        <i class="fas fa-check"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
    
    
</div>
@endsection

@section('script')
<script>

</script>
@endsection