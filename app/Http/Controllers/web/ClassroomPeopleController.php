<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomPeopleController extends Controller
{
//    public function __invoke(Classroom $classroom) //allow call object as function .. route to one action .. invoke preeferd
//
//        //$classroom =  new ClassroomPeopleController;
//        //     $classroom->    //nested of
//        //$classroom('dd')//allow call object as function
//    {
////        dd($classroom->users , $classroom->classwork->first()->users);
//        return view('classrooms.people', compact('classroom'));
//
//    }

    public function index(Classroom $classroom)
    {
        return view('classrooms.people', compact('classroom'));
    }

    public  function  destroy (Request $request, Classroom $classroom ){

        $request->validate([
            'user_id' => ['required','exists:classroom_user,user_id']
        ]);
       $user_id = $request->input('user_id');

       if($user_id == $classroom->user_id) {
           $classroom->users()->detach($user_id);
           toastr()->success('You Leave Classroom Now !');
           return redirect()->back();
       }
        $classroom->users()->detach($user_id);
        toastr()->success('Student Removed !');
        return redirect()->back();
    }

}
