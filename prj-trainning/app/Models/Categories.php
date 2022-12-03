<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug'
    ];

    public function posts() {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    public function postsDashboard()
    {
        return $this->hasMany(Post::class, 'category_id', 'id')->orderByDesc('post_time')->limit(4);
    }
}
