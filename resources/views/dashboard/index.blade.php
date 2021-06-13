@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card o-hidden border-0 shadow-lg py-5 px-5">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{ __('You are logged in!') }}
</div>
@endsection
