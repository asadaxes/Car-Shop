<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    protected $fillable = [
        'name',
        'pricing',
    ];

    public $timestamps = false;
}