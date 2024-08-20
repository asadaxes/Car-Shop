<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invoices extends Model
{
    protected $fillable = [
        'customer_id',
        'pna_id',
        'issued_at'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($invoice) {
            $invoice->issued_at = Carbon::now('Asia/Dhaka');
        });
    }
}