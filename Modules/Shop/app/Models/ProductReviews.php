<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\ProductReviewsFactory;

class ProductReviews extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'product_reviews';
    protected $fillable = [
        'customer_id',
        'product_id',
        'rating',
        'comment'
    ];

    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'customer_id');
    }

    // protected static function newFactory(): ProductReviewsFactory
    // {
    //     // return ProductReviewsFactory::new();
    // }
}
