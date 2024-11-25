<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\DiscountCategoriesFactory;

class DiscountCategories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'discount_categories';
    protected $fillable = [
        'category_name'
    ];

    public function discounts()
    {
        return $this->hasMany(Discounts::class, 'category_discount_id');
    }

    // protected static function newFactory(): DiscountCategoriesFactory
    // {
    //     // return DiscountCategoriesFactory::new();
    // }
}
