<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $video->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('welcome')->with('success', 'Comment added successfully!');
    }
}
