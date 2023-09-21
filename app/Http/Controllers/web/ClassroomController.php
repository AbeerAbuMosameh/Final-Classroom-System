<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Traits\imageTrait;
use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ClassroomController extends Controller
{
    use imageTrait;


    public function __construct()
    {
        $this->middleware('auth');
        // $this->authorizeResource(Classroom::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

//        $classrooms = Classroom::whereHas('users', function ($query) {
//            $query->where('user_id', Auth::id());
//        })
//            ->orderBy('created_at', 'desc')
//            ->withoutGlobalScope(UserClassroomScope::class)
//            ->get();

        $classrooms = Classroom::active()->recent()
            ->orderBy('created_at', 'desc')
            //            ->withoutGlobalScope(UserClassroomScope::class)
            ->get();

        return view('classrooms.index', compact('classrooms'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'section' => 'required|min:3|max:30',
            'subject' => 'required|min:3|max:50',
            'room' => 'required|min:3|max:20',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

//        $request->merge([
//            'code' => Str::random(8),
//            'user_id' => Auth::id(),
//        ]);

        DB::beginTransaction();
        try {
            $classroomData = $request->except('cover_image');

            if ($request->hasFile('cover_image')) {
                $coverImage = $request->file('cover_image');
                $coverImagePath = $this->storeImage($coverImage);
                $classroomData['cover_image'] = $coverImagePath;
            }

            $classroom = Classroom::create($classroomData);
            $classroom->join(Auth::id(), 'teacher');
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);

        }
        return response()->json(['message' => 'Classroom created successfully'], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $classroom = Classroom::findOrFail($id);
        $topics = Topic::where('classroom_id', $id)->get();
        $invitation_link = URL::signedRoute('classroom.join', [
            'classroom' => $classroom->id,
            'code' => $classroom->code,
        ]);

        //get , collection to all model , lazy store 1 place in memory replace models in it

        $classworks = $classroom->classworks()
            ->with('topic')
            ->latest('published_at')
            ->where(function($query){
                $query->wherehas('users',function($query){
                    $query->where('id','=',Auth::id());
                })

                    ->orwherehas('classroom.teachers',function($query){
                        $query->where('id','=',Auth::id());
                    });

            })
        ->get();

        $classworks = $classworks->groupBy('topic_id');
        return view('classrooms.show', compact('classroom', 'topics', 'invitation_link' ,'classworks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'section' => 'String|min:3|max:100',
            'subject' => 'String|min:3|max:100',
            'room' => 'String|min:3|max:20',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->route('classrooms.index');
        }

        $classroomData = $request->except('cover_image');

        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = $this->storeImage($coverImage);

            // Delete previous cover image if it exists
            if ($classroom->cover_image) {
                $this->deleteImage($classroom->cover_image);
            }

            $classroomData['cover_image'] = $coverImageName;
        }

        $classroom->update($classroomData);

        toastr()->success('Classroom updated successfully!');
        return redirect()->route('classrooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
    }

    public function archive(Classroom $classroom)
    {
        $classroom->update(['status' => 'archived']);
        $classroom->save();
        return response()->json(['message' => 'Classroom archived successfully']);
    }

    public function restore(Classroom $classroom)
    {
        $classroom->update(['status' => 'active']);
        $classroom->save();
        return response()->json(['message' => 'Classroom Restored successfully']);
    }

    // Function to display archived classrooms
    public function archived()
    {
        $classrooms = Classroom::Status('archived')->get();
        return view('classrooms.index', compact('classrooms'));
    }

    // Function to display trashed classrooms
    public function trashed()
    {
        $classrooms = Classroom::onlyTrashed()->get();
        return view('classrooms.index', compact('classrooms'));
    }


}


