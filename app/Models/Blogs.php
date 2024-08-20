<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Blogs extends Model
{
    protected $fillable = [
        'thumbnail',
        'title',
        'slug',
        'content',
        'tags',
        'publish_date'
    ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($blog) {
            $blog->publish_date = Carbon::now('Asia/Dhaka');
            $slug = Str::slug($blog->title . '-' . time());
            $blog->slug = $slug;
        });
    }
}