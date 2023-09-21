<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Traits\apiResoponse;
use App\Http\Controllers\web\Controller;
use App\Http\Resources\classroomResourse;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassroomsController extends Controller
{
    use apiResoponse;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')) {
            abort(403 , 'Cant read classrooms');
        }
        $validator = Validator($request->all(), [
            'page' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(__('classrooms.false-status'), $validator->errors()->first(), $validator->errors()->messages(), 400);
        }
        $perPage = $request->has('page') ? $request->page : 2;

        $classrooms = Classroom::with('user:id,name')->with('topics')->withCount('students')->get();

        //  return new classroomResourse2($classrooms);
        //   return classroomResourse::collection($classrooms);
        return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms'), $classrooms, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.create')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'section' => 'required|min:3|max:30',
            'subject' => 'required|min:3|max:50',
            'room' => 'required|min:3|max:20',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(__('classrooms.false-status'), $validator->errors()->first(), $validator->errors(), 422);

        }

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
        return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-create'), $classroom, 201);
    }

    /**
     * Display the specified resource.
     */
    //  public function show($id)
//    {
//
//        $classroom = Classroom::load('users')->find($id);
//        if(is_null($classroom))
//            return $this->apiResponse(__('classrooms.false-status'), __('classrooms.failed') , [] , 422);
//
//        return  new classroomResourse($classroom);
//
//      //  return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-show') , $classroom , 200);
//
//    }
    public function show(Classroom $classroom)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')) {
            abort(403);
        }

        $classroom->load('users')->loadCount('students');
        return new classroomResourse($classroom);

        //  return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-show') , $classroom , 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.update')) {
            abort(403);
        }
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'min:3', 'max:20', Rule::unique('classrooms', 'name')->ignore($classroom->id)],
            'section' => 'sometimes|required|String|min:3|max:100',
            'subject' => 'sometimes|required|String|min:3|max:100',
            'room' => 'sometimes|required|String|min:3|max:20',
            'cover_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(__('classrooms.false-status'), $validator->errors()->first(), $validator->errors(), 422);

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

        return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-update'), $classroom, 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.delete')) {
            abort(403 , 'You can\'t Delete these classroom');
        }
        $classroom = Classroom::whereId($id)->first();
        if (is_null($classroom)) {
            return $this->apiResponse(__('classrooms.false-status'), __('classrooms.failed'), [], 422);
        }
        $classroom->delete();
        return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-delete'), [], 204);
    }

}
