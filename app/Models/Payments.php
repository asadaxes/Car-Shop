<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payments extends Model
{
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'pna_order_id',
        'amount',
        'currency',
        'tran_id',
        'status',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            $payment->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}