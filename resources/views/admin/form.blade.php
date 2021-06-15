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
                <label for="name">Name*</label>
                {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                @error('name')
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
                <label for="password">Password*</label>
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                @error('password')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password-confirm">Password Confirmation*</label>
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm']) !!}
                @error('password_confirm')
                    <div class="text-danger">
                        <small>{{ $message }}</small>
                    </div>
                @enderror
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