<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;

class JoinController extends Controller
{
    public function index(Post $post)
    {
        $user = User::with('posts')->get();
        return $user;
    }
    public function show(User $user)
    {
        return User::with('posts')->where('id', $user->id)->get();
    }

    public function store(User $user)
    {
        $user->posts()->attach(request('user_id'), ['post_id' => request('post_id'), 'user_id' => request('user_id')]);
        return response()->json([
            'message' => 'Brhasil Bergabung'
        ]);
    }
}
