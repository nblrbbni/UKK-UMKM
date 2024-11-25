<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'product_category_id',
        'product_name',
        'slug',
        'description',
        'price',
        'stok_quantity',
        'weight',
        'image1_url',
        'image2_url',
        'image3_url',
        'image4_url',
        'image5_url',
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategories::class, 'product_category_id');
    }

    public function discounts()
    {
        return $this->hasMany(Discounts::class, 'product_id');
    }

    public function order_details()
    {
        return $this->hasMany(Discounts::class, 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlists::class, 'product_id');
    }

    public function product_reviews()
    {
        return $this->hasMany(ProductReviews::class, 'product_id');
    }

    public function getStockStatusAttribute()
    {
        if ($this->stok_quantity > 10) {
            return 'In Stock';
        } elseif ($this->stok_quantity > 0) {
            return 'Low Stock';
        }

        return 'Out of Stock';
    }

    public function getPriceLabelAttribute()
    {
        return number_format((int) $this->price, 0, ',', '.');
    }

    /**
     * Check if product has an active discount
     */
    public function getHasDiscountAttribute()
    {
        return $this->activeDiscount() !== null;
    }

    /**
     * Calculate the discounted price
     */
    public function getDiscountedPriceAttribute()
    {
        $discount = $this->activeDiscount();

        if ($discount) {
            $discountAmount = $this->price * ($discount->percentage / 100);
            return $this->price - $discountAmount;
        }

        return $this->price;
    }

    /**
     * Get formatted discounted price label
     */
    public function getDiscountedPriceLabelAttribute()
    {
        return number_format((int) $this->discounted_price, 0, ',', '.');
    }


    /**
     * Get the active discount for the product
     */
    private function activeDiscount()
    {
        $now = Carbon::now();

        return $this->discounts()
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->orderBy('start_date', 'desc')
            ->first();
    }
}
