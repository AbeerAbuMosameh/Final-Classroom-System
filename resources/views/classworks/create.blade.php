@extends('Dashboard.layout.master')

@section('content')

    <form action="{{ route('classrooms.classworks.store',[$classroom->id, 'type'=>$type]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('classworks._form')
        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>
    </form>

@endsection
