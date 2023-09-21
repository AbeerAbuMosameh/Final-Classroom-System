@extends('Dashboard.layout.master')

@section('content')

    <!--begin::Dashboard-->
    <!--begin::Row-->
    <div class="row">
        @if (!$classrooms->isEmpty())
            @foreach($classrooms as $classroom)
                <div class="col-xl-3 mt-3">
                    <div class="card card-custom">
                        <div class="card-header"
                             style="background-image: url('{{ $classroom->cover_image ? asset($classroom->cover_image) : 'https://placehold.co/600x400' }}'); height: 100px; background-size: cover; background-position: center;">
{{--                        <div class="card-header"--}}
{{--                             style="background-image: url('{{ $classroom->cover_image_url }}'); height: 100px; background-size: cover; background-position: center;">--}}
                          <div class="card-title">
                                <h3 class="card-label" style="color: #FFF;">
                                    {{$classroom->name}}
                                    <p>{{$classroom->section}}</p>
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <div class="dropdown dropdown-inline">
                                    <a href="#" class="btn  btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <i class="ki ki-bold-more-ver text-light"></i>
                                    </a>
                                    <div class="dropdown-menu  dropdown-menu-left">
                                        <ul class="navi">
                                            <li class="navi-item">
                                                <a href="{{route('classrooms.show' , $classroom->id)}}"
                                                   class="navi-link">
                                                    <span class="navi-text">{{__('Show')}}</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link" data-toggle="modal"
                                                   data-target="#editClassModal_{{ $classroom->id }}">
                                                    <span class="navi-text">Edit</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link">
                                                    <span class="navi-text">Copy</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link archive-link"
                                                   data-classroom-id="{{ $classroom->id }}">
                                                    <span
                                                        class="navi-text">{{ $classroom->status === 'active' ? 'Archive' : 'Restore' }}</span>
                                                </a>
                                            </li>
                                            <li class="navi-item">
                                                <a onclick="sweet('{{$classroom->id}}',this)" class="navi-link">
                                                    <span class="navi-text">Delete</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="height: 150px;"></div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{route('classrooms.show' , $classroom->id)}}"
                               class="btn btn-sm btn-clean btn-icon"><i class="fa fa-eye"></i></a>
                            <a onclick="sweet('{{$classroom->id}}',this)" class="btn btn-sm btn-clean btn-icon"
                               title="Delete"><i class="nav-icon fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Edit Class Modals -->
                <div class="modal fade" id="editClassModal_{{ $classroom->id }}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Class</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editClassForm_{{ $classroom->id }}" method="POST"
                                      action="{{ route('classrooms.update', $classroom->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!-- Add your form fields here -->
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{ $classroom->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="section">Section</label>
                                        <input type="text" class="form-control" id="section" name="section"
                                               value="{{ $classroom->section }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Subject</label>
                                        <input type="text" class="form-control" id="subject" name="subject"
                                               value="{{ $classroom->subject }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="room">Room</label>
                                        <input type="text" class="form-control" id="room" name="room"
                                               value="{{ $classroom->room }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="cover_image">Cover Image</label>
                                        <input type="file" class="form-control-file" id="cover_image"
                                               name="cover_image">
                                    </div>
                                    <!-- End of form fields -->
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" form="editClassForm_{{ $classroom->id }}" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-xl-12 mt-3 d-flex justify-content-center">
                <span class="font-size-h1" style="margin: 70px;">No Classroom Founded</span>

                <img src="{{asset('assets/media/error/notfound.svg')}}" width="350px">
            </div>
        @endif
    </div>
    <!--end::Row-->
    <!--end::Dashboard-->

@endsection

@push('js')
    <script>
        function sweet(id, reference) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#ff0303',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/classrooms/' + id,
                        method: 'DELETE',
                        data: {_token: '{{ csrf_token() }}'},
                        success: function (response) {
                            // Show the success message
                            Swal.fire(
                                'Deleted!',
                                'Classroom has been deleted.',
                                'success'
                            ).then((result) => {
                                // Redirect to the index page
                                window.location.href = '{{ route('classrooms.index') }}';
                            });
                        },
                        error: function (xhr, status, error) {
                            // Show the error message
                            Swal.fire(
                                'Error!',
                                'There was an error deleting classroom.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.archive-link').on('click', function (e) {
                e.preventDefault();
                var classroomId = $(this).data('classroom-id');
                var classroomStatus = $(this).find('.navi-text').text();
                if (classroomStatus === 'Archive') {
                    archiveClassroom(classroomId);
                } else if (classroomStatus === 'Restore') {
                    restoreClassroom(classroomId);
                }
            });
        });

        function archiveClassroom(classroomId) {
            $.ajax({
                url: '/classrooms/archive/' + classroomId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    toastr.success('Classroom archived successfully');
                    $('[data-classroom-id="' + classroomId + '"] .navi-text').text('Restore');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error('Error archiving classroom');
                }
            });
        }

        function restoreClassroom(classroomId) {
            $.ajax({
                url: '/classrooms/restore/' + classroomId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    toastr.success('Classroom restored successfully');
                    $('[data-classroom-id="' + classroomId + '"] .navi-text').text('Archive');
                    location.reload();
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    console.error('Error restoring classroom');
                }
            });

        }
    </script>
@endpush
