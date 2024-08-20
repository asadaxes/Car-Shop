<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Pna_Orders extends Model
{
    protected $fillable = [
        'order_id',
        'pna_id',
        'user_id',
        'amount',
        'quantity',
        'delivery_method',
        'shipping_address',
        'status',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->issued_at = Carbon::now('Asia/Dhaka');
        });
    }

    public function pna(){
        return $this->belongsTo(PartAndAccessories::class, 'pna_id');
    }

    public function user(){
        return $this->belongsTo(Users::class, 'user_id');
    }
}