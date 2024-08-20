<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pna_Config extends Model
{
    protected $fillable = [
        'delivery_charge_inside',
        'delivery_charge_outside',
        'tax'
    ];

    public $timestamps = false;
}