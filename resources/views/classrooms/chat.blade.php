@extends('layouts.secondNav')

@section('title' , 'Chat')
@section('content')

    <div class="container pt-5">

        <div aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('classrooms.index')}}" class="text-decoration-none text-dark fs-4">{{$classroom->name}}</a></li>
                <li class="breadcrumb-item active fs-4" aria-current="page">{{__('Chat')}}</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">
                    <ul class="navbar-nav" id=users></ul>
                </div>
            </div>
            <div class="col-md-9">
                <div id="messages" class="border rounded bg-white p-3 mb-3"></div>
                <div id="whisper" class="text-sm fs-5 text-muted"></div>
                <form class="row g-3 align-items-center" id="message-form">
                    <div>
                        <label class="visually-hidden" for="body">Message</label>
                        <div class="input-group">
                            <textarea class="form-control" name="body" id="body" placeholder="Type your message.."></textarea>
                            <div class="input-group-text"> <button type="submit" class="btn btn-sm btn-success"><i class="far fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        const messages = {
            list_url: "{{route('classrooms.messages.index' , [$classroom->id]) }}",
            store_url: "{{ route('classrooms.messages.store' , [$classroom->id] ) }}",
        }

        const csrf_token = "{{ csrf_token() }}";

        const user = {
            id: "{{ Auth::id() }}",
            name: "{{ Auth::user()->name }}"
        }

        const classroom = "{{ $classroom->id }}"
    </script>

    @vite(['resources/js/chat.js'])

@endpush
