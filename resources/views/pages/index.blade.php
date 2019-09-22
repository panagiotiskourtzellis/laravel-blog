@extends('layouts.app')

{{-- Main page of application --}}
@section('content')

    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>This is the main page</p>
        <p>
            <a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> 
            <a class="btn btn-success btn-lg" href="/register" role="button">Register</a>
        </p>
    </div>

@endsection
