<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\web\Controller;
use App\Models\Classroom;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request , Classroom $classroom)
    {

        $request->validate([
            'content' => 'required|string',
            'id' => 'required|int',
            'type' => 'required|in:classwork,post',
        ]);

        Auth::user()->comments()->create([
            'commentable_id' => $request->input('id'),
            'commentable_type' => $request->input('type'),
            'content' => $request->input('content'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $request->input('id'),
        ]);

        $posts = $classroom->posts()->create($request->all());

        return redirect()->route('classrooms.show' , $classroom->id)
            ->with([
                'posts' => $posts,
                'classroom' => $classroom
            ]);


    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
