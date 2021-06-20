@extends('layouts.app')
@section('title', 'Create Transaction')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">

    @if (isset($model))
        {{ Form::model($model, ['enctype' => 'multipart/form-data']) }}
    @else
        {{ Form::open(['enctype' => 'multipart/form-data']) }} 
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="customer-id">Customer*</label>
                {!! Form::select('customer_id', $customers, null, ['class' => 'form-control form-control-select', 'id' => 'customer-id']) !!}
                @error('customer_id')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="laptop">Laptop*</label>
                {!! Form::text('laptop', null, ['class' => 'form-control', 'id' => 'laptop']) !!}
                @error('laptop')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="laptop">Keluhan</label>
                {!! Form::textarea('case', null, ['class' => 'form-control', 'rows' => '3', 'id' => 'case']) !!}
                @error('case')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="dp">Down Payment*</label>
                {!! Form::number('dp', 0, ['class' => 'form-control', 'dp' => 'case']) !!}
                @error('dp')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
    </div>
        
    <div class="row align-items-end" id="services">
        <div class="col-md-5" id="form-services">
            <div class="form-group">
                <label for="service">Service*</label>
                <select class="form-control form-control-select" id="service" name="services[]">
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->service }} - {{ $service->price }}</option>    
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5" id="form-prices">
            <div class="form-group">
                <label for="price">Harga (Harga Default = 0)</label>
                {!! Form::number('prices[]', 0, ['class' => 'form-control', 'id' => 'price']) !!}
            </div>
        </div>
        <div class="col-md-2 btn-services">
            <div class="form-group">
                <div id="custom" class="btn btn-success btn-block">
                    <i class="fas fa-fw fa-plus"></i>
                    <span>Tambah Service</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center">
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-circle btn-lg">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
    
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $("#custom").click(function(){
            $("#form-services").clone().appendTo( "#services" );
            $("#form-prices").clone().appendTo( "#services" ).find("input[type='number']").val("0");
        });
    });
</script>
@endsection