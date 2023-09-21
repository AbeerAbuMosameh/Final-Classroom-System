@extends('Dashboard.layout.master')

@section('title','Show Topic')

@section('content')
    <div class="container">

        <h1>welcome {{ $topic->name }} (# {{$topic->classroom_id}}) </h1>
        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">
                    <span class="text-success fs-2 "></span>
                </div>
            </div>
            <div class="col-md-9">

            </div>
        </div>
    </div>
@endsection
