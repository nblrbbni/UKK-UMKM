<?php

namespace Modules\Shop\Repositories\Front;

use Modules\Shop\Models\ProductCategories;
use Modules\Shop\Repositories\Front\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findAll($options = [])
    {
        return ProductCategories::orderBy('category_name', 'asc')->get();
    }

    public function findBySlug($slug)
    {
        return ProductCategories::where('slug', $slug)->firstOrFail();
    }
}
