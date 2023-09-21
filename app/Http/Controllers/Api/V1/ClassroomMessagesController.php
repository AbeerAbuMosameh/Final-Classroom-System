<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\MessageSent;
use App\Http\Controllers\web\Controller;
use App\Http\Resources\classroomResourse;
use App\Models\Classroom;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClassroomMessagesController extends Controller
{
    /**
     * @param Classroom $classroom
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Classroom $classroom)
    {
      return  $classroom->messages()->addSelect('created_at as sent_at')->with('sender:id,name')->latest()->paginate(30);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Classroom $classroom , Message $message)
    {

        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(__('classrooms.false-status'), $validator->errors()->first(), $validator->errors(), 422);

        }

        $classroom->messages()->create([
            'sender_id' => $request->user()->id,
            'body' => $request->post('body'),
        ]);

        event(new MessageSent($message));


        return $this->apiResponse(__('classrooms.true-status'), __('classrooms.classrooms-create'), $classroom, 201);
    }

    /**
     * Display the specified resource.
     */

    public function show(Message $message)
    {
        return $message;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom, Message $message)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
        ]);
        $message->update([
            'body' => $request->post('body')
        ]);
        return $message;
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Classroom $classroom, Message $message)
    {
        $message->delete();
        return [];
    }

}
