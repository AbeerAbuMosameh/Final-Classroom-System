<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::orderBy('name', 'DESC')->get(); //return Collection of topics
        $classrooms = Classroom::orderBy('name', 'DESC')->get(); //return Collection of classrooms
        $users = User::orderBy('name', 'DESC')->get(); //return Collection of users

        return view('topics.index', compact('topics','classrooms','users'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,Classroom $classroom)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:topics,name,NULL,id,classroom_id,' . $classroom->id,
        ]);

        if (!$validator->fails()) {
            Topic::create([
                     'name' => $request->name,
                     'classroom_id' => $classroom->id,
                     'user_id' => Auth::id(),
                ]
            );
            toastr()->success('Topics Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('classrooms.show', ['classroom' => $classroom, 'tab' => 'topicContent']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,$id)
    {
        $topic = Topic::findorFail($id);
        return view('topics.show', compact('topic'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        if (!$validator->fails()) {
            $topic = Topic::find($request->get('topic_id'));
            if (!$topic) {
                toastr()->error('Topic not found.');
            } else {
                $topic->update([
                    'name' => $request->name,
                ]);
                toastr()->success('Topic updated successfully!');
            }
        } else {
            toastr()->error($validator->errors()->first());
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $classroom, $topic)
    {
        Topic::findOrFail($topic)->delete();
    }
}
