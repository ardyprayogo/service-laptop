@extends('layouts.app')
@section('title', isset($model) ? 'Update Service Types' : 'Create Service Types')
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
                <label for="type">Type*</label>
                {!! Form::text('type', null, ['class' => 'form-control', 'id' => 'type']) !!}
                @error('type')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="service_desc">Type Description*</label>
                {!! Form::text('service_desc', null, ['class' => 'form-control', 'id' => 'service_desc']) !!}
                @error('service_desc')
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