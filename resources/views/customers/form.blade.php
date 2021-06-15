@extends('layouts.app')
@section('title', isset($model) ? 'Update Customers' : 'Create Customers')
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
                <label for="customer">Customer Name*</label>
                {!! Form::text('customer', null, ['class' => 'form-control', 'id' => 'customer']) !!}
                @error('customer')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="telp">Telp*</label>
                {!! Form::text('telp', null, ['class' => 'form-control', 'id' => 'telp']) !!}
                @error('telp')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email*</label>
                {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                @error('email')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="gender">Sex*</label>
                @if (isset($model))
                    {!! Form::select('gender', ['l' => 'Male', 'p' => 'Female'], $model['gender'], ['class' => 'form-control form-select', 'id' => 'gender']) !!}   
                @else
                    {!! Form::select('gender', ['l' => 'Male', 'p' => 'Female'], null, ['class' => 'form-control form-select', 'id' => 'gender']) !!} 
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="address">Address*</label>
                {!! Form::textarea('address', null, ['class' => 'form-control', 'rows' => '3']) !!}
                @error('address')
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