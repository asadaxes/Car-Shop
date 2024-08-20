<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Vehicles extends Model
{
    protected $fillable = [
        'dealer_id',
        'brand_id',
        'model',
        'category_id',
        'campaign',
        'images',
        'features',
        'details',
        'description',
        'price',
        'mileage',
        'fuel_type',
        'condition',
        'exterior_color',
        'interior_color',
        'engine',
        'drivetrain',
        'model_year',
        'registration_year',
        'status',
        'slug',
        'publish_date'
    ];

    public $timestamps = false;
    
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($car) {
            $car->publish_date = Carbon::now('Asia/Dhaka');
            $slug = Str::lower(Str::slug($car->condition . '-' . $car->brand->name . '-' . $car->model . '-' . $car->mileage . '-' . $car->category->title . '-' . time()));
            $car->slug = $slug;
        });
    }

    public function dealer()
    {
        return $this->belongsTo(Users::class, 'dealer_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(VehiclesCategory::class, 'category_id');
    }

    public function payment()
    {
        return $this->belongsTo(Payments::class, 'vehicle_id');
    }
}