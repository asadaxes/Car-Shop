<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiclesCategory extends Model
{
    protected $fillable = [
        'title'
    ];

    public $timestamps = false;

    public function vehicles()
    {
        return $this->hasMany(Vehicles::class, 'category_id');
    }
}