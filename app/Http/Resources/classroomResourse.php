<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class classroomResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'meta' => [
                'subject' => $this->subject,
                'section' => $this->section,
                'room' => $this->room,
                'student_count' => $this->students_count ?? 0,
            ],
            'user' => [
                'name' => $this->user->name,

            ],
        ];
    }
}
