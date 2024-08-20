<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pna_Reviews extends Model
{
    protected $fillable = [
        'pna_id',
        'user_id',
        'rating',
        'feedback',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($review) {
            $review->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    public function pna()
    {
        return $this->belongsTo(PartAndAccessories::class, 'pna_id');
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}