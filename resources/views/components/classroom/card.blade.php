<div class="card">
    <div class="card-body">
        @if ($classroom->cover_image)
            <img class="pr-4" src="{{asset($classroom->cover_image)}}" height="50px"
                 width="50px"
                 alt="Logo">
        @endif
        <h5 class="card-title">{{$classroom->name}}</h5>
        <p class="card-text">{{$classroom->section}} {{$classroom->room}}</p>
        <a href="{{route('classrooms.show' , $classroom->id)}}" class="btn btn-primary">Show</a>
        <a href="{{route('classrooms.edit' , $classroom->id)}}" class="btn btn-dark">Edit</a>
        <form action="{{route('classrooms.destroy' , $classroom->id)}}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-danger">Delete </button>
        </form>
    </div>
</div>
