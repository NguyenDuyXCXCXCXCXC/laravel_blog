<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id', 'user_id', 'user_id', 'comment', 'status', 'post_id', 'comment_time'
    ];

    // be longs to
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // has many for admin
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // has many active
    public function repliesActive()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('status', '=', '1');
    }

}
