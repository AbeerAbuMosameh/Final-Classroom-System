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
                <div class="col-auto pb-3 pl-10">
                    <a href="#" class="navi-link" data-toggle="modal"
                       data-target="#createTopicForm">
                        <span class="btn btn-primary"><i class="fas fa-plus"></i> Create New Topic</span>
                    </a>
                </div>

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
        <div class="col-xl-3 mt-3">

        </div>
        <div class="col-xl-9 mt-3">
            <div class="flex-md-row-fluid">
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex ">
                                <h2>Topics of this class room</h2>
                                <a href="#" class="navi-link" data-toggle="modal"
                                   data-target="#createTopicForm" style="margin-left: 394px;">
                                    <span class="btn btn-primary"><i class="fas fa-plus"></i></span>
                                </a>

                            </div>
                            <div class="border-top my-5"></div>

                            @if($classwork->isEmpty())
                                <p>No classworks found for this classroom.</p>
                            @else
                                <div class="table-responsive">
                                    @forelse($classworks as $classwork)

                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#flush-collapse{{$classwork->id}}"
                                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                                        {{$classwork->title}}
                                                    </button>
                                                </h2>
                                                <div id="flush-collapse{{$classwork->id}}"
                                                     class="accordion-collapse collapse"
                                                     data-bs-parent="#accordionFlushExample">
                                                    <div
                                                        class="accordion-body"> {{$classwork->desceiption}}</code> </div>
                                                </div>
                                            </div>

                                        </div>
                                        </td>
                                    @empty
                                        <div class="col-xl-12 mt-3 d-flex justify-content-center">
                                            <span class="font-size-h1" style="margin: 70px;">No Classroom Founded</span>

                                            <img src="{{asset('assets/media/error/notfound.svg')}}" width="350px">
                                        </div>

                                        @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

