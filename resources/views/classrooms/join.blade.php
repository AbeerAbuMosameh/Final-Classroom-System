@extends('Dashboard.layout.master')

@section('content')

    <div class="card card-custom card-stretch gutter-b bg-light">
        <div class="card-header h-auto border-0">
            <!--begin::Title-->
            <div class="card-title py-5">
                <h3 class="card-label">
                    <span class="d-block text-dark font-weight-bolder">Join Classroom Now !!</span>
                    <span class="d-block text-dark-50 mt-2 font-size-sm">You are joining the class as a student.</span>
                </h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar">
                <ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link py-2 px-4" href="{{route('classrooms.show',$classroom->id)}}">
                            <span class="nav-text font-size-sm">Back</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--end::Toolbar-->
        </div>

        <div class="card-body pt-2 pb-0 mt-n3">
            <div class="tab-content mt-5" id="myTabTables2">
                <div style="margin-left: 380px;">
                    <img src="{{asset('./assets/media/logos/classroom.svg')}}" style="margin-left: 50px;">
                    <h2>Google Classroom </h2>
                    <p style="margin-left: -150px;">Classroom helps classes communicate, save time, and stay organized. <a href="#"> Learn more</a></p>
                </div>
            </div>
            <hr>
            <div class="tab-content mt-5" id="myTabTables2">
                <div style="margin-left: 400px;">
                <h2 class="card-title align-items-start flex-column">
                    <span class="card-label font-weight-bolder text-dark"> {{$classroom->name}} Classroom</span>
                </h2>
                <div class="card-toolbar" style="margin-left: 45px;">
                    <ul class="nav nav-pills nav-pills-sm nav-dark-75">
                        <li class="nav-item">
                            <form class="d-inline" action="{{ route('classroom.join.store',$classroom->id) }}"
                                  method="post">
                                @csrf
                                <button class="btn btn-sm btn-primary btn-delete">Join Now</button>

                            </form>
                        </li>

                    </ul>
                </div>

                </div>
                <br>
                <p style="margin-left: 250px;">By joining, you agree to share contact information with people in your class</p>

            </div>
        </div>
    </div>

@endsection
