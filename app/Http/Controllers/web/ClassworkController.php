<?php

namespace App\Http\Controllers\web;

use App\Enums\ClassworkType;
use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use App\Models\Classwork;
use App\Models\ClassworkUser;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassworkController extends Controller
{

    public function getType(Request $request)
    {
        try {
            return classworkType::from($request->query('type'));

        } catch (\Exception $e) {

        }
        $type = $request->query('type');
        $allowed_types = [
            classwork::TYPE_ASSIGNMENT,
            classwork::TYPE_MATERIAL,
            classwork::TYPE_QUESTION,
        ];

        if (!in_array($type, $allowed_types)) {
            $type = classwork::TYPE_ASSIGNMENT;
        };

        return $type;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Classroom $classroom)
    {
        //get , collection to all model , lazy store 1 place in memory replace models in it
        $classworks = $classroom->with(['classsworks', 'topic'])->orderBy('published_at')->get(); //Eager load
        dd($classworks);
        return view('classworks.index', compact('classworks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, Classroom $classroom)
    {

//        $response = Gate::inspect('create-classwork', [$classroom]);
//        if (!$response->allowed()) {
//            abort(403, $response->message());
//        }

        $type = $this->getType($request)->value;
        $classwork = new classwork();

        return view('classworks.create', compact('classroom', 'classwork', 'type'));

    }

    /**
     * @param Request $request
     * @param Classroom $classroom
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Classroom $classroom)
    {

        //   Gate::authorize('create-classwork', [$classroom]);
        $type = $this->getType($request);


        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['required', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn() => $type == 'assignemt'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->back();
        }


        $request->merge([
            'user_id' => Auth::id(),
            'type' => $type->value, //Enum
        ]);

        $classwork = $classroom->classworks()->create($request->all());
        $users = $request->input('students', []);

        foreach ($users as $userId) {
            $classwork_user = new ClassworkUser();
            $classwork_user->user_id = $userId;
            $classwork_user->classwork_id = $classwork->id;
            $classwork_user->save();
        }


        toastr()->success('Classwork Created Successfully!');

        return redirect()->route('classrooms.show', ['classroom' => $classroom, 'tab' => 'classworksContent']);

    }

    /**
     * Display the specified resource.
     */
    public function show(  $classroom , $classwork)
    {
        $submission = Auth::user()->submissions()->where('classwork_id', $classwork)->get();
        $classwork = Classwork::find($classwork);
        $classroom = Classroom::find($classroom);
        $topics = Topic::where('classroom_id' , $classroom->id)->get();

        $submissions = Auth::user()->submissions()->where('classwork_id',$classwork->id)->get();


        return view('classworks.show', compact('classroom', 'submissions', 'classwork','topics'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $classroom, $classwork)
    {

        $classwork = Classwork::findOrFail($classwork);
        $type = $classwork->type;
        $assigned = $classwork->users()->pluck('id')->toArray();

        return view('classworks.edit', compact('classroom', 'classwork', 'type','assigned'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Classwork $classwork )
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'int', 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn() => $classwork->type == 'assignemt'), 'numeric', 'min:0'],
            'options.due' => ['nullable', 'date', 'after:published_at'],
        ]);
        $classwork->users()->detach();
        $classwork->users()->sync($request->input('students'),[]);
        $classwork->update($validator->validated());
        toastr()->success('Classwork Updated Successfully!');

        return redirect()->route('classrooms.show', ['classroom' => $classroom, 'tab' => 'classworksContent']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $classroom, $classworks)
    {
        Classwork::findOrFail($classworks)->delete();

    }
}
