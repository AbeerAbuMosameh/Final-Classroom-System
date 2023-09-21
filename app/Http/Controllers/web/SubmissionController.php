<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\ClassWork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request, Classwork $classwork, $classWorkId)
    {

        Gate::authorize('create-submission',[$classwork]);

        $classwork = Classwork::find($classWorkId);

        $request->validate([
            'files' => ['required', 'array'],
            'file.*' => ['file', new ForbiddenFile('text/x-php', 'application/x-httpd-php')]
        ]);
        $assigned = $classwork->users()->where('id', auth()->user()->id)->exists();
        if (!$assigned) {
            abort(403);
        }
        DB::beginTransaction();

        try {
            $data = [];
            foreach ($request->file('files') as $file) {
                $data [] = [
                    'user_id' => auth()->user()->id,
                    'classwork_id' => $classwork->id,
                    'content' => $file->store("submissions/{$classwork->id}"),
                    'type' => 'file',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

            }
            Submission::insert([$data]);

            ClassworkUser::where([
                'user_id' => auth()->user()->id,
                'classwork_id' => $classwork->id,
            ])->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());

        }

        return back()->with('success', 'Work Submitted');
    }

    public function file(Submission $submission)
    {
        $user = Auth::user();
        $isTeacher = $submission->classwork->classroom->teachers()->where('id', $user->id)->exists();
        $isOwner = $submission->user_id = $user->id;

        if (!$isTeacher && !$isOwner) {
            abort(403);
        }
        return response()->file(storage_path('app/' . $submission->content));


    }

}

