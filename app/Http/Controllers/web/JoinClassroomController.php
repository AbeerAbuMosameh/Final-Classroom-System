<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Exception;

class JoinClassroomController extends Controller
{

    public function create($id)
    {


        $classroom = Classroom::whereId($id)
              ->withoutGlobalScope(UserClassroomScope::class)
            ->first();

        try {

            $this->exists($id, Auth::id());
        } catch (Exception $e) {

            return redirect()->route('classrooms.show', $id);
        }
        return view('classrooms.join', compact('classroom'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'role' => 'in:student,teacher'
        ]);

        $classroom = Classroom::whereId($id)
            ->withoutGlobalScope(UserClassroomScope::class)
            ->first();
        try {
            $this->exists($id, Auth::id());
        } catch (Exception $e) {
            return redirect()->route('classrooms.show', $id);
        }

        $classroom->join(Auth::id(), $request->input('role','student'));


        return redirect()->route('classrooms.show',$id);

//        DB::table('classroom_user')->insert([
//            'classroom_id' => $classroom->id,
//            'user_id' => Auth::id(),
//            'role' => $request->input('role', 'student'),
//            'created_at' => now(),
//        ]);

        //return view('classrooms.join', compact('classroom'));
    }

//    protected function exists(Classroom $classroom, $user_id)
//    {
//        //search in pivot table if this user exist previously
//        $exists =  $classroom->users()->wherePivot('user_id',$user_id)->exists(); // search on sql relation
//     //   $classroom->users->where('user_id',$user_id)->exists(); //bring all user on collection users then search
////        $exists = DB::table('classroom_user')->where('classroom_id', $classroom_id)
////            ->where('user_id', $user_id)->exists();
////
////
//        if ($exists) {
//            throw  new \Exception('You joined This Class previously');
//        }

//    }


    protected function exists($classroom_id, $user_id)
    {
        $exists =   DB::table('classroom_user')
            ->where('classroom_id', $classroom_id)
            ->where('user_id', $user_id)
            ->exists();

    }

}
