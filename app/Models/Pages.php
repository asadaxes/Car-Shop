<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pages extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'content',
        'position'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($page) {
            $slug = Str::slug($page->name);
            $page->slug = $slug;
        });
    }
}