<?php

namespace App\Http\Resources;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class classroomResourse2 extends ResourceCollection
{

    public $collects = classroomResourse::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = $this->collection->map(function ($model){
            return [
                'id' => $model->id,
                'name' => $model->name,
                'code' => $model->code,
                'image' => $model->cover_image,
                'meta' => [
                    'section' => $model->section,
                    'room' => $model->room,
                    'subject' => $model->subject,
                    'student_count' => $model->students_count ?? 0,
                    'theme' => $model->theme,
                ],
                'user' => [
                    'name' => $model->user?->name, // no user - null sfe operator

                ],
            ];
        });
    }
}
