<?php

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\ProductCategories;
use Modules\Shop\Models\Products;
use Modules\Shop\Repositories\Front\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function findAll($options = [])
    {
        $perPage = $options['per_page'] ?? null;
        $categorySlug = $options['filter']['category'] ?? null;

        $products = Products::with(['product_category']);

        if ($categorySlug) {
            $category = ProductCategories::where('slug', $categorySlug)->firstOrFail();

            $products = $products->where('product_category_id', $category->id);
        }

        if ($perPage) {
            return $products->paginate($perPage);
        }

        return $products->get();
    }

    public function findBySlug($productSlug)
    {
        return Products::where('slug', $productSlug)->firstOrFail();
    }

    public function findByID($id)
    {
        return Products::where('id', $id)->firstOrFail();
    }
}
