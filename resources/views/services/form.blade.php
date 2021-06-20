@extends('layouts.app')
@section('title', isset($model) ? 'Update Service' : 'Create Service')
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
                <label for="service">Service*</label>
                {!! Form::text('service', null, ['class' => 'form-control', 'id' => 'service']) !!}
                @error('service')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="service-type">Type*</label>
                @if (isset($model))
                    {!! Form::select('service_type_id', $types, $model['service_type_id'], ['class' => 'form-control form-select', 'id' => 'service-type']) !!}   
                @else
                    {!! Form::select('service_type_id', $types, null, ['class' => 'form-control form-select', 'id' => 'service-type']) !!} 
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="price">Harga*</label>
                {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'price']) !!}
                @error('price')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="desc">Keterangan*</label>
                {!! Form::text('desc', null, ['class' => 'form-control', 'id' => 'desc']) !!}
                @error('desc')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
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
</script>
@endsection