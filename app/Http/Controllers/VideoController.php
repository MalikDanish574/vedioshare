<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('user', 'comments')->latest()->get();
        return view('welcome', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|mimes:mp4,mov,avi|max:102400', // Max 100MB
        ]);

        $path = $request->file('video')->store('videos', 'public');

        $video = Video::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => $path,
        ]);

        return redirect()->route('welcome')->with('success', 'Video shared successfully!');
    }

    public function like(Request $request, Video $video)
    {
        $video->increment('likes');
        return response()->json(['likes' => $video->likes]);
    }
}
