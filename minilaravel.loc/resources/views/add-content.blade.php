@extends('layouts.site')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>{{$message}}</h1>
            <p>{{$header}}</p>
            <p><a class="btn btn-primary btn-lg" href="#"role="button">Learn more</a></p>


        </div>


    </div>
    @endsection