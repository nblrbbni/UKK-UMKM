<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\DiscountsFactory;

class Discounts extends Model
{
    use HasFactory;

    protected $table = 'discounts';
    protected $fillable = [
        'category_discount_id',
        'product_id',
        'start_date',
        'end_date',
        'percentage'
    ];

    public function discount_categories()
    {
        return $this->belongsTo(DiscountCategories::class, 'category_discount_id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
