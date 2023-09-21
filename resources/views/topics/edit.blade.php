@extends('Dashboard.layout.master')

@section('title','Edit Topic')

@section('content')
    <div class="container">
        <h1>Edit Classrooms!</h1>
        <form action="{{route('classrooms.update', $classroom->id)}}" method="POST">
            <!-- in this comment -- disable just for html code anything else executed-->
            {{--  this is comment for blade -- random token --}}
            {{--  <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
            @csrf
            {{--  Form Method Sppofing--}}
            {{--  <input type="hidden" name="_method" value="put""> --}}
            @method('put')

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="name" placeholder="Class Name"
                       value="{{$classroom->name}}">
                <label for="name">Class Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="section" class="form-control" id="section" placeholder="Section"
                       value="{{ $classroom->section }}">
                <label for="section">Section</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject"
                       value="{{ $classroom->subject}}">
                <label for="subject">Subject</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="room" class="form-control" id="room" placeholder="Room" value="{{$classroom->room}}">
                <label for="room">Room</label>
            </div>
            <div class="form-floating mb-3">
                <input type="file" name="cover_image" class="form-control" id="cover_image" placeholder="Room">
                <label for="cover_image">Cover Image</label>
            </div>
            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-primary">Update Class Room</button>
            </div>


        </form>
    </div>
    {{--pass data--}}
@endsection
