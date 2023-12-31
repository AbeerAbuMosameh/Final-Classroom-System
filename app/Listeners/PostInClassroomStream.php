<?php

namespace App\Listeners;

use App\Events\ClassworkCreated;
use App\Models\Stream;
use Illuminate\Support\Str;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostInClassroomStream
{
    
    public function __construct()
    {
        
    }

    public function handle(ClassworkCreated $event): void
    {
        $classwork = $event->classwork;

        $content = __(':name posted a new :type :title' , [
            'name' => $classwork->user->name,
            'type' => __($classwork->type->value),
            'title' => $classwork->title,
        ]);

        Stream::create([
          'classroom_id' => $classwork->classroom_id,
          'user_id' => $event->classwork->user_id,
          'content' => $content,
          'link' => route('classrooms.classworks.show' ,[$classwork->classroom_id , $classwork->id] )
        ]);
    }
}
