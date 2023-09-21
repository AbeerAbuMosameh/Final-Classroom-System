@extends('Dashboard.layout.master')

@section('content')

    <h1>{{ $classwork->classroom->name }} Classroom <h3 class="text-muted">{{ $classwork->title }} Classwork</h3> </h1>
    <hr>


    <h4> {{ $classwork->description }}</h4>
    <hr>



    <div class="row">
        <div class="col-md-8">
            <h3>Commments</h3>

            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <input type="hidden" name="id" value="{{ $classwork->id }}">
                        <input type="hidden" name="type" value="classwork">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="content" placeholder="Add Your Comment Here "
                                   aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>
                <button style="margin-top: 20px" type="submit" class="btn btn-primary">Create</button>
            </form>

            <div class="mt-4">

                @forelse ($classwork->comments as $comment)
                    <div class="row border border-secondery" style="padding: 20px;margin:10px;">
                        <div class="col-md-2">
                            <img src="https://ui-avatars.com/api/?name={{ $comment->user->name }}" alt="">
                        </div>
                        <div class="col-md-10">
                            By {{ $comment->user?->name }} - {{ $comment->created_at->diffForHumans() }}
                            <br>
                            <p>{{ $comment->content}}</p>
                        </div>

                    </div>

                @empty
                    <h4 class="text-center">No Comments Found</h4>
                @endforelse

            </div>

        </div>
        <div class="col-md-4">
            @if ($submissions->count() ?? 0)
                <div class="">
                    <ul>
                        <h4>Your Submitted Files</h4>

                        @foreach ($submissions as  $item)

                            <li><a href="{{ route('submissions.file',$item->id) }}">File # {{ $loop->iteration }}</a>
                            </li>

                        @endforeach
                    </ul>
                </div>

            @else
                <div class="">
                    <h3>Upload Files</h3>
                    <form action="{{ route('submissions.store', $classwork->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <input type="file" class="form-control" multiple name="files[]"
                                   accept="image/*,application/pdf" placeholder="Select Your Files"
                                   aria-describedby="emailHelp">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

            @endif


        </div>
    </div>

@endsection

@push('js')

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
    </script>

@endpush
