@extends('Dashboard.layout.master')

@section('content')

    <div class="d-flex justify-content-center">
        <ul class="nav nav-tabs" id="classroomTabs" role="tablist" style="justify-content: center;margin-left: 360px;">
            <li class="nav-item">
                <a class="nav-link active" id="stream-tab" data-toggle="tab" href="#streamContent" role="tab"
                   aria-controls="streamContent" aria-selected="true">Stream</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="classworks-tab" data-toggle="tab" href="#classworksContent" role="tab"
                   aria-controls="classworksContent" aria-selected="false">Classworks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="people-tab" data-toggle="tab" href="#peopleContent" role="tab"
                   aria-controls="peopleContent" aria-selected="false">People</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="topic-tab" data-toggle="tab" href="#topicContent" role="tab"
                   aria-controls="topicContent" aria-selected="false">Topic</a>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="classroomTabsContent">
        <div class="tab-pane fade show active" id="streamContent" role="tabpanel" aria-labelledby="stream-tab">
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
                        <div class="col-12 pb-5 pl-20">
                            <a href="{{$invitation_link }}" class="navi-link" target="_top">
                                <span class="btn btn-primary"> Invitation Link</span>
                            </a>
                        </div>
                        <li class="nav-item d-flex col-sm flex-grow-1">
                    <span class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column ">
                        <h3 class="nav-text font-size-h4 py-2 font-weight-bold ">Class Code : </h3>
                        <span class="nav-text font-size-lg py-2 font-weight-bold text-center font-size-h1">
                            {{ $classroom->code }}</span>
                    </span>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-9 mt-3">
                    <div class="flex-md-row-fluid ">
                        <div class="col-xxl-9">
                            <div class="card ">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-success mr-5">
                                    <span class="symbol-label">
                                        <img src="{{asset('assets/media/svg/avatars/007-boy-2.svg')}}"
                                             class="h-75 align-self-end" alt="">
                                    </span>
                                        </div>
                                        <span
                                            class="text-muted font-weight-bold font-size-lg">What’s on your mind, Jerry?</span>
                                    </div>
                                    <form action="{{route('posts.store' , $classroom->id)}}" method="post"
                                          id="kt_forms_widget_2_form" class="pt-10 ql-quil ql-quil-plain">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $classroom->id }}">
                                        <input type="hidden" name="type" value="post">


                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" name="content"
                                                       placeholder="{{ __('Tell us something ..') }}"
                                                       class="rounded-pill border border-none w-100 p-3 me-2">
                                            </div>
                                            <div class="col-3">
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                        class="far fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                    </form>


                                </div>
                                <div class="posts ">
                                    @foreach ($classroom->posts()->latest()->get() as $post)
                                        <div class="d-flex p-2 mt-2 align-items-center">
                                            <img src="{{asset('assets/media/logos/post.png')}}" width="40" height="40"
                                                 class="rounded-circle me-2" alt="">
                                            <div class="ms-2 mt-1">
                                                <h6>{{ $post->user?->name }} {{__('add a new post :')}} {{ $post->content }}</h6>
                                                <span class="text-secondary">{{$post->created_at->format('j F')}}</span>
                                            </div>
                                        </div>
                                    @endforeach


                                    @foreach ($classroom->streams()->latest()->get() as $stream)
                                        <div class="d-flex p-2 mt-2 align-items-center">
                                            <img src="{{asset('imgs/icon.png')}}" width="40" height="40"
                                                 class="rounded-circle me-2" alt="">
                                            <div class="ms-2 mt-1">
                                                <h6>{{__($stream->content)}}</h6>
                                                <small
                                                    class="text-secondary">{{$stream->created_at->format('j F')}}</small>
                                                <small><a href="{{$stream->link}}"
                                                          class="text-success fw-bold text-decoration-none">View
                                                        instruction</a></small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="classworksContent" role="tabpanel" aria-labelledby="classworks-tab">
            <div class="row">

                <div class="col-xl-12 mt-3">
                    <div class="row">
                        <div class="col-xl-9 input-group mb-12">
                            <input type="text" id="classworkSearch" class="form-control"
                                   placeholder="Search for classworks...">
                            <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>
                            </div>
                        </div>
                        <div class="col-xl-3 mt-3">
                            <ul class=" nav nav-pills  m-0 p-0 " role="tablist">
                                <div class="col-12 pb-5">
                                    <div class="dropdown">
                                        <div class="topbar-item mr-4" data-toggle="dropdown" data-offset="10px,0px">
                                            <div class="btn btn-primary btn-sm btn-clean" style="   margin-top: -13px;
" id="kt_quick_panel_toggle">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px"
                                 viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path
                                        d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z"
                                        fill="#000000"/>
                                </g>

                            </svg>
                            <!--end::Svg Icon-->
                        </span> New Classwork
                                            </div>
                                        </div>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-left">
                                            <ul class="navi navi-hover py-5">
                                                <li class="navi-item">
                                                    <a href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}"
                                                       class="navi-link">
                                                        <span class="navi-text">Assignment</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}"
                                                       class="navi-link">
                                                        <span class="navi-text">Material</span>
                                                    </a>
                                                </li>
                                                <li class="navi-item">
                                                    <a href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}"
                                                       class="navi-link">
                                                        <span class="navi-text">Questions</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>

                    @forelse($classworks as $group)
                        <h3>{{ $group->first()->topic->name }}</h3>
                        <div id="noResultsMessage_{{ $group->first()->topic->id }}" class="text-center mt-3"
                             style="display: none;">
                            No Results Found
                        </div>
                        <hr class="green-separator border">
                        <div class="accordion accordion-light  accordion-toggle-arrow" id="accordionExample5">
                            @foreach ($group as $classwork)

                                <div class="card">
                                    <div class="card-header" id="headingOne4">
                                        <div class="card-title" data-toggle="collapse"
                                             data-target="#collapse{{ $classwork->id }}">
                                            <i class="flaticon2-copy"></i> {{$classwork->title}}
                                        </div>
                                    </div>
                                    <div id="collapse{{ $classwork->id }}" class="collapse"
                                         data-parent="#accordionExample5">
                                        <div class="card-body">
                                            {{$classwork->description}}
                                        </div>

                                        <div class="card-body">

                                            <a class="btn btn-sm btn-icon btn-primary navi-link ml-5"
                                               href="{{ route('classrooms.classworks.edit', [$classwork->classroom->id , $classwork->id]) }}">
                                                <i class="far fa-edit"></i> </a>

                                            <a class="btn btn-sm btn-icon btn-info navi-link ml-5"
                                               href="{{ route('classrooms.classworks.show', [$classwork->classroom->id , $classwork->id]) }}">
                                                <i class="far fa-eye"></i> </a>


                                            <a class="btn btn-sm btn-icon btn-danger navi-link ml-5"
                                               onclick="sweet2({{ $classroom->id }}, {{ $classwork->id }})">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                        <br><br>
                    @empty
                        <p class="text-center fs3"> No Classworks Found</p>
                    @endforelse


                </div>

            </div>
        </div>
        <div class="tab-pane fade" id="peopleContent" role="tabpanel" aria-labelledby="people-tab">
            <div class="row">
                <div class="col-xl-12 mt-3">
                    <div class="card gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-success">Teachers</h3>
                        </div>
                        <!--end::Header-->

                        @forelse($classroom->teachers as $user)
                            <div class="card-body pt-2">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-white mr-5">
                                        <div class="symbol-label">
                                            <img src="{{ asset('assets/media/svg/avatars/004-boy-1.svg') }}"
                                                 class="h-75 align-self-end"
                                                 alt="">
                                        </div>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                        <a href="#"
                                           class="text-dark text-hover-primary mb-1 font-size-lg">{{ $user->name }}</a>
                                        <span class="text-muted">{{ $user->name }}</span>
                                    </div>
                                    <!--end::Text-->
                                    <!--begin::Dropdown-->
                                    <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                         data-placement="left"
                                         data-original-title="Quick actions">
                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon"
                                           data-toggle="dropdown"
                                           aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover">
                                                <li class="navi-item">
                                                    <form
                                                        action="{{ route('classrooms.people.destroy',  $classroom->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        <button type="submit" class="btn navi-link">
                                                                   <span class="navi-text">
                                                                       <span style="color: red">Leave Group</span>
                                                                   </span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                            <!--end::Navigation-->
                                        </div>
                                    </div>
                                    <!--end::Dropdown-->
                                </div>
                            </div>
                        @empty
                            <p class="text-center fs3"> No Teacher in This Classroom</p>
                        @endforelse
                    </div>

                    <div class="card gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-success">Students</h3>
                        </div>
                        @forelse($classroom->students as $user)
                            <div class="card-body pt-2">
                                <!--begin::Item-->
                                <div class="d-flex align-items-center mb-2">
                                    <!--begin::Symbol-->
                                    <div class="symbol symbol-40 symbol-light-white mr-5">
                                        <div class="symbol-label">
                                            <img src="{{asset('assets/media/svg/avatars/004-boy-1.svg')}}"
                                                 class="h-75 align-self-end" alt="">
                                        </div>
                                    </div>
                                    <!--end::Symbol-->
                                    <!--begin::Text-->
                                    <div class="d-flex flex-column flex-grow-1 font-weight-bold">
                                        <a href="#"
                                           class="text-dark text-hover-primary mb-1 font-size-lg">{{$user->name}}</a>
                                        <span class="text-muted">{{$user->name}}</span>
                                    </div>
                                    <!--end::Text-->
                                    <!--begin::Dropdown-->
                                    <div class="dropdown dropdown-inline ml-2" data-toggle="tooltip" title=""
                                         data-placement="left" data-original-title="Quick actions">
                                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="ki ki-bold-more-hor"></i>
                                        </a>
                                        <div class="dropdown-menu p-0 m-0 dropdown-menu-right">
                                            <!--begin::Navigation-->
                                            <ul class="navi navi-hover">
                                                <li class="navi-item">
                                                    <form
                                                        action="{{ route('classrooms.people.destroy',  $classroom->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                        <button type="submit" class="btn navi-link">
                                                                   <span class="navi-text">
                                                                       <span style="color: red">Delete</span>
                                                                   </span>
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>

                                            <!--end::Navigation-->
                                        </div>
                                    </div>
                                    <!--end::Dropdown-->
                                </div>
                            </div>
                        @empty
                            <p class="text-center fs3"> No Student in This Classroom</p>
                        @endforelse
                    </div>


                </div>
            </div>

        </div>
        <div class="tab-pane fade" id="topicContent" role="tabpanel" aria-labelledby="topic-tab">
            <div class="col-xl-12 mt-3">
                <div class="flex-md-row-fluid">
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex ">
                                    <h2>Topics of this class room</h2>
                                    <a href="#" class="navi-link" data-toggle="modal"
                                       data-target="#createTopicForm" style="margin-left: 500px;">
                                        <span class="btn btn-primary"><i class="fas fa-plus"></i>New Topic</span>
                                    </a>

                                </div>
                                <div class="border-top my-5"></div>

                                @if($topics->isEmpty())
                                    <p>No topics found for this classroom.</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>Topic Name</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($topics as $topic)
                                                <tr>
                                                    <td>{{ $topic->name }}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-icon btn-primary navi-link ml-5"
                                                           data-toggle="modal"
                                                           data-target="#editTopicForm{{ $topic->id }}">
                                                            <i class="far fa-edit"></i>
                                                        </a>

                                                        <a class="btn btn-sm btn-icon btn-danger"
                                                           onclick="sweet({{ $classroom->id }}, {{ $topic->id }})">
                                                            <i class="far fa-trash-alt"></i>
                                                        </a>

                                                    </td>
                                                    <form id="editTopicForm{{ $topic->id }}" method="POST"
                                                          action="{{ route('classrooms.topics.update', ['classroom' => $classroom->id, 'topic' => $topic->id]) }}"
                                                          enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal fade" id="editTopicForm{{ $topic->id }}"
                                                             tabindex="-1" role="dialog"
                                                             aria-labelledby="staticBackdrop" aria-hidden="true">
                                                            <input type="hidden" class="form-control" id="topic_id"
                                                                   name="topic_id" value="{{$topic->id}}">

                                                            <div class="modal-dialog modal-dialog-scrollable"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                                            Edit Topic Name</h5>
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                            <i aria-hidden="true"
                                                                               class="ki ki-close"></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label>Name <span
                                                                                    class="text-danger">*</span></label>
                                                                            <input type="text" name="name"
                                                                                   value="{{old('name', $topic->name)}}"
                                                                                   @class(['form-control','is-invalid' => $errors->has('name')]) placeholder="Enter name">
                                                                            <x-error-feedback name="name"/>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                                class="btn btn-light-primary font-weight-bold"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                        <button type="submit" id="saveChangesBtn"
                                                                                class="btn btn-primary font-weight-bold">
                                                                            Edit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal-->
            <form id="createTopicForms" method="POST" action="{{ route('classrooms.topics.store', $classroom->id) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="modal fade" id="createTopicForm" tabindex="-1" role="dialog"
                     aria-labelledby="staticBackdrop" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Topic Name</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-close"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{old('name')}}"
                                           @class(['form-control','is-invalid' => $errors->has('name')]) placeholder="Enter name">
                                    <x-error-feedback name="name"/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary font-weight-bold"
                                        data-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" id="saveChangesBtn" class="btn btn-primary font-weight-bold">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        // Wait for the document to be fully loaded
        document.addEventListener("DOMContentLoaded", function () {
            // Get the 'tab' query parameter from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab');

            // Check if the 'tab' query parameter is set to 'classworksContent'
            if (activeTab === 'classworksContent') {
                // Activate the "Classworks" tab
                const classworksTab = document.querySelector('#classworks-tab');
                if (classworksTab) {
                    classworksTab.classList.add('active');
                }

                // Show the "Classworks" tab content
                const classworksContent = document.querySelector('#classworksContent');
                if (classworksContent) {
                    classworksContent.classList.add('show', 'active');
                }

                // Remove 'active' and 'show' classes from the "Stream" tab and its content
                const streamTab = document.querySelector('#stream-tab');
                if (streamTab) {
                    streamTab.classList.remove('active');
                }
                const streamContent = document.querySelector('#streamContent');
                if (streamContent) {
                    streamContent.classList.remove('show', 'active');
                }
            } else if (activeTab === 'topicContent') {
                // Activate the "Classworks" tab
                const topicTab = document.querySelector('#topic-tab');
                if (topicTab) {
                    topicTab.classList.add('active');
                }

                // Show the "Classworks" tab content
                const topicContent = document.querySelector('#topicContent');
                if (topicContent) {
                    topicContent.classList.add('show', 'active');
                }

                // Remove 'active' and 'show' classes from the "Stream" tab and its content
                const streamTab = document.querySelector('#stream-tab');
                if (streamTab) {
                    streamTab.classList.remove('active');
                }
                const streamContent = document.querySelector('#streamContent');
                if (streamContent) {
                    streamContent.classList.remove('show', 'active');
                }

            }
            urlParams.delete('tab');
            const newTabParam = urlParams.toString() ? `?${urlParams.toString()}` : ''; // Preserve the question mark if other parameters exist
            const newUrl = `${window.location.pathname}${newTabParam}`;
            history.replaceState({}, document.title, newUrl);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script>
        // Get references to the search input and all classwork items
        const classworkSearchInput = document.getElementById("classworkSearch");
        const classworkItems = document.querySelectorAll(".accordion-toggle-arrow .card");

        // Add an event listener to the search input field
        classworkSearchInput.addEventListener("input", function () {
            const searchQuery = classworkSearchInput.value.toLowerCase();

            // Loop through all classwork items and show/hide based on the search query
            classworkItems.forEach(function (classworkItem) {
                const classworkTitle = classworkItem.querySelector(".card-title").textContent.toLowerCase();
                if (classworkTitle.includes(searchQuery)) {
                    classworkItem.style.display = "block";
                } else {
                    classworkItem.style.display = "none";
                }
            });

            // Loop through all groups and show/hide the "No Results" message for each group
            document.querySelectorAll("[id^='noResultsMessage_']").forEach(function (message) {
                message.style.display = "none"; // Hide all messages initially
            });

            let noResults = true; // Flag to check if there are no results

            classworkItems.forEach(function (classworkItem) {
                if (classworkItem.style.display === "block") {
                    noResults = false; // At least one result found
                    const groupID = classworkItem.closest(".accordion-toggle-arrow").id;
                    const groupMessage = document.getElementById(`noResultsMessage_${groupID}`);
                    groupMessage.style.display = "none"; // Hide the message for this group
                }
            });

            // Show/hide the "No Results" message for all groups based on the flag
            if (noResults) {
                document.querySelectorAll("[id^='noResultsMessage_']").forEach(function (message) {
                    message.style.display = "block";
                });
            }
        });
    </script>
    <script>
        function sweet(classroomId, topicId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#ec3838',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/classrooms/' + classroomId + '/topics/' + topicId,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Topic has been deleted.',
                                'success'
                            ).then((result) => {
                                // Reload the current page
                                window.location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the topic.',
                                'error'
                            );
                        }
                    });
                }
            });
        }

        function sweet2(classroomId, $classworkId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#ec3838',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/classrooms/' + classroomId + '/classworks/' + $classworkId,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Classwork has been deleted.',
                                'success'
                            ).then((result) => {
                                // Reload the current page
                                window.location.reload();
                            });
                        },
                        error: function (xhr, status, error) {
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting the Classwork.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush
