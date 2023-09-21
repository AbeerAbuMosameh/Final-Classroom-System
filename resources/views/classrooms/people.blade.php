@extends('Dashboard.layout.master')

@section('content')

    <!--begin::Dashboard-->
    <!--begin::Row-->

    <div class="row justify-content-center bgi-size-cover bgi-no-repeat py-6 px-6 py-md-10 px-md-0"
         style="background-image: url({{ asset($classroom->cover_image) }}); border-radius: 10px;">
        <div class="col-md-9">
            <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                <div class="d-flex flex-column align-items-md-start">
                    <h1 class="display-4 text-white font-weight-boldest mt-20">{{$classroom->name}}
                        <br> {{$classroom->section}}</h1>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 mt-3">
            <ul class=" nav nav-pills  m-0 p-0 " role="tablist">
                <!--begin::Item-->

                <li class="nav-item d-flex col-sm flex-grow-1">

                    <span class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column ">

                        <h3 class="nav-text font-size-h4 py-2 font-weight-bold ">Class Code : </h3>

                        <span class="nav-text font-size-lg py-2 font-weight-bold text-center font-size-h1">
                            {{ $classroom->code }}</span>

                    </span>

                </li>

                <!--end::Item-->
            </ul>
        </div>
        <div class="col-xl-9 mt-3">
            <div class="flex-md-row-fluid">
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex ">
                                <h2>People of this Classroom</h2>
{{--                                <a href="#" class="navi-link" data-toggle="modal"--}}
{{--                                   data-target="#createTopicForm" style="margin-left: 394px;">--}}
{{--                                    <span class="btn btn-primary"><i class="fas fa-plus"></i></span>--}}
{{--                                </a>--}}

                            </div>
                            <div class="border-top my-5"></div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>People Name</th>
                                            <th>Role</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($classroom->users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->pivot->role }}</td>
                                                <td>
                                                 <form method="POST" action="{{route('classrooms.people.destroy',$classroom->id)}}">
                                                     @csrf
                                                     @method('delete')
                                                     <input multiple accept="app" ype="hidden" name="user_id" value="{{$user->id}}">
                                                    <button class="btn btn-sm btn-icon btn-danger" type="submit">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                 </form>
                                                </td>
                                            </tr>

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

