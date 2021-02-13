<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'thumbnail', 'slug', 'place', 'postDate'];

    public function users()
    {
        return $this->belongsToMany('\App\User', 'user_post', 'user_id', 'post_id');
    }

    public function getTakeImageAttribute()
    {
        return "/storage/" . $this->thumbnail;
    }
}
