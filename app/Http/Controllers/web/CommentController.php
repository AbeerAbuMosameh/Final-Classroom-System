<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
            'id' => ['required', 'int'],
            'type' => ['required', 'in:classwork,post'],
        ]);

        // dd(Auth::user());

        Auth::user()->comments()->create([
            'commentable_id' => $request->input('id'),
            'commentable_type' => $request->input('type'), // App\Models\Classwork
            'content' => $request->input('content'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        toastr()->success('Comment added');
        return redirect()->back();
    }
}
