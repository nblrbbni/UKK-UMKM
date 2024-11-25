<?php

namespace Modules\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Shop\Database\Factories\ProductCategoriesFactory;

class ProductCategories extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'category_name',
        'slug',
        'image_url'
    ];

    public function products()
    {
        return $this->hasMany(Products::class, 'product_category_id');
    }

    public static function childIDs($parentID = null)
    {
        $product_categories = ProductCategories::select('id', 'category_name')
            ->where('product_category_id', $parentID)
            ->get();

        $childIDs = [];
        if (!empty($product_categories)) {
            foreach ($product_categories as $category) {
                $childIDs[] = $category->id;
                $childIDs = array_merge($childIDs, ProductCategories::childIDs($category->id));
            }
        }

        return $childIDs;
    }
}
