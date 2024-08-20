<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Models\Pna_Orders;
use App\Models\invoices;

class Users extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'whatsapp_no',
        'password',
        'avatar',
        'flag',
        'country',
        'city',
        'state',
        'zip_code',
        'gender',
        'birth_date',
        'is_active',
        'is_admin',
        'joined_date'
    ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            $user->joined_date = Carbon::now('Asia/Dhaka');
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function hasPurchased($pna_id, $customer_id)
    {
        $order = Pna_Orders::where('pna_id', $pna_id)->where('user_id', $customer_id)->first();
        if ($order) {
            $invoiceExists = Invoices::where('customer_id', $customer_id)->where('pna_id', $order->order_id)->exists();
            return $invoiceExists;
        }
        return false;
    }    
}