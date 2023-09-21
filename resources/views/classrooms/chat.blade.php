@extends('Dashboard.layout.master')

@section('content')

    <div class="container">
        <h1>{{ $classroom->name }} - Chat Room</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="border rounded p-3 text-center">

                </div>
            </div>
            <div class="col-md-9">
                <div id="messages" class="border rounded bg-light p-3 mb-3">

                </div>
                <form class="row g-3 align-items-center" id="message-form">
                    <div class="col-9">
                        <label class="visually-hidden" for="body">Username</label>
                        <div class="input-group">
                            <div class="input-group-text"></div>
                            <textarea class="form-control" name="body" id="body"
                                      placeholder="Type your message.."></textarea>
                        </div>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        (function ($) {
            function getMessages(page = 1) {
                $.ajax({
                    method: "get",
                    url: "{{route('classrooms.messages.index', [$classroom->id])}}",
                    headers:{
                        "x-api-key" : ""
                    },
                    success: function (response) {
                        for (let i in response.data) {
                            let message = response.data[i];
                            addMessage(message)
                        }
                    }
                })
            }

            function addMessage(message, prepend = false) {
                let html = `<div class="bg-info rounded p-2 mt-2">
                               <div>
<b>${message.sender.name}</b>
- <span class="text-muted">${message.sent_at}</span>
</div>
                               <div> ${message.body}</div>
                            </div>`;

                if (prepend) {
                    return $('messages').prepend(html);
                }
                $('messages').append(html);
            }

            function send(message) {
                $.post(
                    "{{route('classrooms.messages.index', [$classroom->id])}}",
                    {
                        _token: "{{csrf_token()}}",
                        body: message,
                    },
                    function () {
                        addMessage({
                            sender:{
                                name: "{{Auth::user()->name}}",
                            },
                            body: message ,
                            sent_at: (new Date().toString())
                        })
                    }
                );
            }

            $("message-form").on('submit', function (e) {
                e.preventDefault();
                send($(this).find('textarea').val());
            })
            $(document).ready(function () {
                getMessages();
            })


        })(jQuery);
    </script>
@endpush
