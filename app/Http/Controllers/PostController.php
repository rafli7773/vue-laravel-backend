<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index(Post $post)
    {
        return $post->latest()->paginate(6);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'postDate' => 'required',
            'place' => 'required|min:3',
        ]);


        $pathFile = request()->file('thumbnail')->store('images', 'public');
        $pathFile = Storage::url($pathFile);

        Post::create([
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'place' => request('place'),
            'postDate' => request('postDate'),
            'thumbnail' => $pathFile
        ]);

        return response()->json([
            'message' => request('title') . ' berhasil',
        ]);
    }

    public function destroy(Post $post)
    {
        File::delete(public_path($post->thumbnail));
        $post->users()->detach();
        $post->delete();
        return response()->json([
            'message' => $post->title . " berhasil di hapus",
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate(request(), [
            'title' => 'required|min:3',
            'place' => 'required|min:3',
            'postDate' => 'required',
        ]);

        if ($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('images', 'public');
            $thumbnail = Storage::url($thumbnail);
            File::delete(public_path($post->thumbnail));
        } else {
            $thumbnail = $post->thumbnail;
        }

        $post->update([
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'postDate' => request('postDate'),
            'place' => request('place'),
            'thumbnail' => $thumbnail,
        ]);

        return response()->json([
            'message' => request('title') . " berhasil di edit",
        ]);
    }

    public function search(Post $post)
    {
        $query = request('query');
        // return "$query";

        return Post::where('title', 'like', "%$query%")->latest()->get();
    }
}
