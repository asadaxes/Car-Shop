<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PartAndAccessories extends Model
{
    protected $fillable = [
        'title',
        'type',
        'slug',
        'description',
        'images',
        'regular_price',
        'sale_price',
        'quantity',
        'brand_id',
        'category_id',
        'tags',
        'has_warranty',
        'reviews',
        'meta_title',
        'meta_description',
        'publish_date',
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->publish_date = Carbon::now('Asia/Dhaka');
            $slug = Str::lower(Str::slug($product->title . '-' . $product->sale_price . '-' . time()));
            $product->slug = $slug;
        });
    }

    public function brand()
    {
        return $this->belongsTo(PnA_Brands::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(PnA_Category::class, 'category_id');
    }

    public function user_reviews()
    {
        return $this->hasMany(PnA_Reviews::class, 'pna_id');
    }

    public function averageRating()
    {
        $totalReviews = $this->user_reviews()->count();
        if ($totalReviews > 0) {
            return round($this->user_reviews()->avg('rating'), 1);
        }
        return 0.0;
    }

    public function starRating()
    {
        $averageRating = $this->averageRating();
        return round($averageRating);
    }

    public function starRatingDistribution()
    {
        $distribution = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
        ];

        foreach ($this->user_reviews as $review) {
            $rating = $review->rating;

            if (array_key_exists($rating, $distribution)) {
                $distribution[$rating]++;
            }
        }

        return $distribution;
    }
}