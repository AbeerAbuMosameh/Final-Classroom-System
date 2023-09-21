@extends('Dashboard.layout.master')

@section('title','Topics')

@section('content')
    <div class="container mt-4">

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col">
                        <h2>Topics</h2>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createTopicModal"><i class="fas fa-plus"></i> Create New Topic
                        </button>
                    </div>
                </div>

                <div class="list-group">
                    @foreach($topics as $topic)
                        <span class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $topic->name }}</h5>
                                <button type="submit" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#editTopicModal"><i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('topics.destroy', $topic->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </span>
                        <div class="modal fade" id="editTopicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create Topic</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add form fields for topic creation -->
                                        <form id="createTopicForm" action="{{ route('topics.update', $topic->id) }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <div class="form-group">
                                                <label for="topicName">Topic Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $topic->name) }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="classroom">Classroom</label>
                                                <select class="form-control" id="classroom_id" name="classroom_id">
                                                    @foreach($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}" {{ $classroom->id == $topic->classroom_id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="user">User</label>
                                                <select class="form-control" id="user_id" name="user_id">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}" {{ $user->id == $user->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="createTopicBtn">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="createTopicModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Create Topic</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Add form fields for topic creation -->
                                        <form id="createTopicForm" action="{{ route('topics.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="topicName">Topic Name</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="classroom">Classroom</label>
                                                <select class="form-control" id="classroom_id" name="classroom_id">
                                                    @foreach($classrooms as $classroom)
                                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="user">User</label>
                                                <select class="form-control" id="user_id" name="user_id">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="createTopicBtn">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>

            </div>
        </div>
    </div>
    <!-- Create Topic Modal -->


    <script>
        document.getElementById('createTopicBtn').addEventListener('click', function () {
            document.getElementById('createTopicForm').submit();
        });
    </script>

@endsection
