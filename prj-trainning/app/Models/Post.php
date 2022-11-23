<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'photo',
        'content',
        'user_id',
        'category_id',
        'views',
        'hot_flag',
        'post_time',
        'views',
    ];

    // be longs to
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    // has many
    public function comments() {
        return $this->hasMany(Comment::class);
    }

}
